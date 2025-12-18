<?php
session_start(); // 세션 시작 (맨 위에 필수)
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Demo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5', secondary: '#EC4899' } } } }
    </script>
</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">
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

    <main class="flex-grow flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-4xl aspect-video bg-gray-800 rounded-2xl shadow-2xl overflow-hidden relative group">
            <iframe class="w-full h-full" src="" title="Demo Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center group-hover:opacity-0 transition pointer-events-none">
                <span class="text-xl font-medium text-white/80">S.E.R.A 감정 분석 시연</span>
            </div>
        </div>
        <p class="mt-8 text-gray-400 text-center max-w-2xl">
            이 영상은 S.E.R.A가 실제 음성 데이터를 처리하여 감정 값을 도출하는 과정을 보여줍니다.
        </p>
    </main>
</body>
</html>