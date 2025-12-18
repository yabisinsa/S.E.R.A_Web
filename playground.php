<?php
session_start(); // 세션 시작 (가장 먼저!)

// #----------여기까진 DB 연결 및 설정에 대한 내용
$host = 'localhost';
$user = 'root';
$pw = ''; 
$db_name = 'sample01_db';

$conn = new mysqli($host, $user, $pw, $db_name);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// #----------여기까진 게시글 저장 및 파일 업로드 처리 로직
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'write') {
    $title = $_POST['title'];
    $writer = $_POST['writer'];
    $tag = $_POST['tag'];
    $content = $_POST['content'];
    $file_name = null; // 기본값은 없음

    // 파일 업로드 로직 시작
    if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        // 파일 정보 가져오기
        $file_info = pathinfo($_FILES['upfile']['name']);
        $ext = strtolower($file_info['extension']);
        
        // 확장자 검사 (보안)
        if (!in_array($ext, $allowed_ext)) {
            echo "<script>alert('허용되지 않는 파일 형식입니다.'); history.back();</script>";
            exit;
        }

        // 파일명 난수화 (보안: 셸 업로드 공격 방지)
        $new_name = uniqid('img_', true) . '.' . $ext;
        $upload_path = $upload_dir . $new_name;

        if (move_uploaded_file($_FILES['upfile']['tmp_name'], $upload_path)) {
            $file_name = $new_name;
        }
    }

    // DB 저장 (Prepared Statement)
    $stmt = $conn->prepare("INSERT INTO playground_table (title, writer, tag, content, file_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $writer, $tag, $content, $file_name);
    
    if ($stmt->execute()) {
        echo "<script>alert('게시글이 저장되었습니다.'); location.href='playground.php';</script>";
    } else {
        echo "<script>alert('저장 실패: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// #----------여기까진 게시글 목록 조회 로직
$sql = "SELECT * FROM playground_table ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Playground</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5', secondary: '#EC4899' } } } }
        function toggleModal() {
            const modal = document.getElementById('writeModal');
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-primary tracking-tight">S.E.R.A</a>
            <nav class="flex space-x-4 font-medium text-gray-600">
                <a href="playground.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">게시판</a>
                <a href="features.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">소개</a>
                <a href="demo.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">시연 영상</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="mypage.php" class="px-4 py-2 rounded-full bg-indigo-50 text-indigo-600 font-bold transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        마이페이지 (<?= htmlspecialchars($_SESSION['username']) ?>님)
                    </a>
                <?php else: ?>
                    <a href="login.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">로그인</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 pt-32 pb-12">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">자유 게시판</h2>
                <p class="text-gray-500 mt-1">이미지 업로드 기능이 추가되었습니다.</p>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button onclick="toggleModal()" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-md flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    글쓰기
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="p-4 w-16 text-center">번호</th>
                            <th class="p-4 w-20 text-center">사진</th>
                            <th class="p-4 w-24 text-center">분류</th>
                            <th class="p-4">제목</th>
                            <th class="p-4 w-32 text-center">작성자</th>
                            <th class="p-4 w-40 text-center">날짜</th>
                            <th class="p-4 w-20 text-center">조회</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="border-b border-gray-50 hover:bg-indigo-50/30 transition duration-150 group cursor-pointer">
                                <td class="p-4 text-center text-gray-400 font-medium"><?= $row['id'] ?></td>
                                <td class="p-4 text-center">
                                    <?php if($row['file_name']): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['file_name']) ?>" class="w-10 h-10 object-cover rounded-lg mx-auto border border-gray-200" alt="첨부">
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-md bg-indigo-50 text-indigo-600">
                                        <?= htmlspecialchars($row['tag']) ?>
                                    </span>
                                </td>
                                <td class="p-4 font-medium text-gray-800 group-hover:text-indigo-600 transition">
                                    <?= htmlspecialchars($row['title']) ?>
                                </td>
                                <td class="p-4 text-center text-gray-500"><?= htmlspecialchars($row['writer']) ?></td>
                                <td class="p-4 text-center text-gray-400"><?= $row['created_at'] ?></td>
                                <td class="p-4 text-center text-gray-400"><?= $row['views'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400">등록된 게시글이 없습니다.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="writeModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 relative">
            <button onclick="toggleModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">✕</button>
            <h3 class="text-xl font-bold mb-4 text-indigo-600">새 게시글 작성</h3>
            
            <form action="playground.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="write">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">작성자</label>
                        <input type="text" name="writer" value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">태그 (분류)</label>
                        <select name="tag" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                            <option value="잡담">잡담</option>
                            <option value="질문">질문</option>
                            <option value="정보">정보</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">제목</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">사진 첨부</label>
                    <input type="file" name="upfile" accept="image/*" class="w-full px-3 py-2 border rounded-lg text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">내용</label>
                    <textarea name="content" rows="4" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition">저장하기</button>
            </form>
        </div>
    </div>

    <footer class="bg-gray-900 text-gray-400 py-8 text-center mt-auto">
        <p class="text-sm">&copy; <?php echo date("Y"); ?> S.E.R.A Project. All rights reserved.</p>
    </footer>
</body>
</html>