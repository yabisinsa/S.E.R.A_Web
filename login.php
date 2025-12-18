<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.E.R.A - Login</title>
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
                <a href="playground.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">게시판</a>
                <a href="features.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">소개</a>
                <a href="demo.php" class="px-4 py-2 rounded-full hover:bg-gray-200 transition">시연 영상</a>
                <a href="login.php" class="px-3 py-2 rounded-full bg-indigo-50 text-indigo-600 transition">로그인</a>
            </nav>
        </div>
    </header>

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md border border-gray-100 mt-20">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 mb-2">Welcome Back</h1>
            <p class="text-gray-500">S.E.R.A 프로젝트에 로그인하세요.</p>
        </div>

        <form action="login_check.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">이메일</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition" placeholder="admin@sera.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">비밀번호</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-indigo-500 transition" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition transform hover:scale-[1.02]">
                로그인
            </button>
        </form>
        
        <div class="mt-6 text-center space-y-2">
            <p class="text-sm text-gray-500">
                계정이 없으신가요? 
                <a href="register.php" class="text-indigo-600 font-bold hover:underline">회원가입</a>
            </p>
            <div class="pt-2 border-t border-gray-100">
                <a href="index.php" class="text-xs text-gray-400 hover:text-gray-600">메인으로 돌아가기</a>
            </div>
        </div>
        </div>
</body>
</html>