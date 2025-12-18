<?php
session_start(); // 세션 시작 (로그인 정보 확인용)
?>
<!DOCTYPE html>
<html lang="ko" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Noto Sans KR', 'sans-serif'] }, colors: { primary: '#4F46E5', secondary: '#EC4899' } } } }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 leading-relaxed flex flex-col min-h-screen">
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

    <main class="flex-grow flex items-center justify-center">
        <section class="container mx-auto px-6 pt-32 pb-20 flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2 text-center md:text-left space-y-6">
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-primary text-sm font-semibold">감정 분석 AI</span>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                    "말해봐 <span class="text-indigo-600">너의 감정을"</span>
                </h1>
                <p class="text-lg text-gray-600">S.E.R.A는 음성을 듣고 분석하여 감정을 도출해 내는 AI입니다.</p>
                
                <form action="features.php" method="POST">
                    <input type="hidden" name="access_token" value="sera_secure_access">
                    <button type="submit" class="px-8 py-4 bg-primary text-white font-bold rounded-full hover:bg-indigo-600 transition shadow-lg">
                        특징 보기 
                    </button>
                </form>
            </div>
            <div class="md:w-1/2">
                <img src="sera.png" onerror="this.src='https://placehold.co/600x500?text=S.E.R.A'" alt="Hero" class="rounded-3xl shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500">
            </div>
        </section>
    </main>
    <footer class="bg-gray-900 text-gray-400 py-8 text-center mt-auto">
        <p class="text-sm">&copy; <?php echo date("Y"); ?> S.E.R.A Project. All rights reserved.</p>
    </footer>
</body>
</html>