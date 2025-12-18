<?php
session_start();

// 1. 비로그인 접근 차단
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('로그인이 필요한 페이지입니다.'); location.href='login.php';</script>";
    exit;
}

// 2. DB 연결 및 사용자 정보 조회
$host = 'localhost';
$user = 'root';
$pw = '';
$db_name = 'sample01_db';

$conn = new mysqli($host, $user, $pw, $db_name);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 현재 로그인한 사용자의 모든 정보 가져오기
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - 개인 정보</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5' } } } }
    </script>
</head>

<body class="bg-white text-gray-800 flex flex-col min-h-screen">

    <header class="fixed w-full top-0 z-50 bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold text-primary tracking-tight">S.E.R.A</a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600"><?= htmlspecialchars($row['username']) ?>님</span>
                <a href="logout.php" class="text-sm bg-gray-100 px-3 py-2 rounded hover:bg-gray-200 transition">로그아웃</a>
            </div>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 pt-24 pb-20 max-w-2xl">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-normal text-gray-900 mb-2">개인 정보</h1>
            <p class="text-gray-500 text-sm">S.E.R.A 서비스를 사용하는 사용자님의 기본 정보입니다.</p>
        </div>

        <div class="border border-gray-300 rounded-lg overflow-hidden">
            
            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium w-24 text-gray-500">프로필 사진</span>
                    <span class="text-sm text-gray-400">사진을 추가하여 계정을 맞춤설정하세요</span>
                </div>
                <div class="w-12 h-12 rounded-full overflow-hidden bg-indigo-100 flex items-center justify-center text-indigo-500">
                    <?php if($row['profile_img']): ?>
                        <img src="<?= htmlspecialchars($row['profile_img']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">이름</span>
                    <span class="text-base font-medium text-gray-900"><?= htmlspecialchars($row['username']) ?></span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">성별</span>
                    <span class="text-base text-gray-900"><?= htmlspecialchars($row['gender']) ?></span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">이메일</span>
                    <div class="flex flex-col">
                        <span class="text-base text-gray-900"><?= htmlspecialchars($row['email']) ?></span>
                    </div>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">휴대전화</span>
                    <span class="text-base text-gray-900"><?= $row['phone'] ? htmlspecialchars($row['phone']) : '<span class="text-gray-400">전화번호 추가</span>' ?></span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">생년월일</span>
                    <span class="text-base text-gray-900"><?= $row['birthdate'] ? htmlspecialchars($row['birthdate']) : '<span class="text-gray-400">생일 추가</span>' ?></span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

            <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition border-b border-gray-200 cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">주소</span>
                    <span class="text-base text-gray-900"><?= $row['address'] ? htmlspecialchars($row['address']) : '<span class="text-gray-400">주소 설정 안 됨</span>' ?></span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

             <div class="flex justify-between items-center p-4 hover:bg-gray-50 transition cursor-pointer">
                <div class="flex items-center gap-4 w-full">
                    <span class="text-sm font-medium w-24 text-gray-500">비밀번호</span>
                    <span class="text-2xl text-gray-900 leading-none pt-2">••••••••</span>
                </div>
                <span class="text-gray-400 text-xl">›</span>
            </div>

        </div>
    </main>

    <footer class="bg-gray-50 text-gray-500 py-6 text-center text-xs mt-auto">
        <p>&copy; <?php echo date("Y"); ?> S.E.R.A Project. All rights reserved.</p>
    </footer>
</body>
</html>