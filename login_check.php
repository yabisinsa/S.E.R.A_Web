<?php
// login_check.php
session_start(); // 로그인 세션 시작

$host = 'localhost';
$user = 'root';
$pw = '';
$db_name = 'sample01_db';

$conn = new mysqli($host, $user, $pw, $db_name);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 데이터 수신
$email = $_POST['email'];
$password = $_POST['password'];

// 1. 이메일로 사용자 정보 조회
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // 2. 비밀번호 검증 (Hash 비교)
    if (password_verify($password, $hashed_password)) {
        // 로그인 성공: 세션에 정보 저장
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        
        echo "<script>alert('" . $row['username'] . "님 환영합니다!'); location.href='index.php';</script>";
    } else {
        // 비밀번호 불일치
        echo "<script>alert('비밀번호가 틀렸습니다.'); history.back();</script>";
    }
} else {
    // 이메일 없음
    echo "<script>alert('존재하지 않는 계정입니다.'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>