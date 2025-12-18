<?php
session_start(); // 세션 시작
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Features</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5', secondary: '#EC4899' } } } }
    </script>
</head>

<body class="bg-white text-gray-800 flex flex-col min-h-screen">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 text-indigo-600 text-2xl font-bold">1</div>
                <h3 class="text-xl font-bold mb-2">단순한구조</h3>
                <p class="text-gray-600">복잡한 인터페이스 없이 녹음만 하면 됩니다.</p>
            </div>
            <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 text-indigo-600 text-2xl font-bold">2</div>
                <h3 class="text-xl font-bold mb-2">빠른 속도</h3>
                <p class="text-gray-600">결과출력이 매우 빠른 속도로 실행 됩니다.</p>
            </div>
            <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100 hover:shadow-xl transition">
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 text-indigo-600 text-2xl font-bold">3</div>
                <h3 class="text-xl font-bold mb-2">깔끔한 디자인</h3>
                <p class="text-gray-600">모바일 완벽하게 지원합니다.</p>
            </div>
        </div>
    </main>
    <footer class="bg-gray-900 text-gray-400 py-8 text-center">
        <p class="text-sm">Secure POST Access Verified.</p>
    </footer>
</body>
</html>