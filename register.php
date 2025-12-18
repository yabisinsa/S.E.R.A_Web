<?php
// #----------여기까진 DB 연결 및 회원가입 처리 로직 (PHP)
$host = 'localhost';
$user = 'root';
$pw = '';
$db_name = 'sample01_db';

// 폼이 제출되었는지 확인 (POST 방식)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($host, $user, $pw, $db_name);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // 1. 비밀번호 일치 확인
    if ($password !== $password_confirm) {
        echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
        exit;
    }

    // 2. 이메일 중복 체크 (Prepared Statement)
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('이미 존재하는 이메일입니다.'); history.back();</script>";
        exit;
    }
    $check_stmt->close();

    // 3. 비밀번호 암호화 (Security Check: Hash)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 4. DB 저장
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('회원가입 성공! 로그인해주세요.'); location.href='login.php';</script>";
    } else {
        echo "<script>alert('가입 실패: " . $stmt->error . "'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
    exit; // 처리가 끝나면 HTML을 보여주지 않고 종료
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5', secondary: '#EC4899' } } } }
    </script>
</head>

<body class="bg-gray-50 h-screen flex items-center justify-center">
    
    <header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-primary tracking-tight">S.E.R.A</a>
            <nav class="flex space-x-4 font-medium text-gray-600">
                <a href="login.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">로그인</a>
            </nav>
        </div>
    </header>

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100 mt-20">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 mb-2">Sign Up</h1>
            <p class="text-gray-500">S.E.R.A의 새로운 멤버가 되어보세요.</p>
        </div>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">이름</label>
                <input type="text" name="username" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition" placeholder="홍길동">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">이메일</label>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition" placeholder="example@sera.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">비밀번호</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition" placeholder="8자 이상 입력">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">비밀번호 확인</label>
                <input type="password" name="password_confirm" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition">
            </div>
            
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition transform hover:scale-[1.02] mt-4">
                회원가입 완료
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                이미 계정이 있으신가요? 
                <a href="login.php" class="text-indigo-600 font-bold hover:underline">로그인</a>
            </p>
        </div>
    </div>
</body>
</html>