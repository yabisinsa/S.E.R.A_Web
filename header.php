<!DOCTYPE html>
<html lang="ko" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>깔끔한 PHP 웹페이지</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Noto Sans KR', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // 세련된 인디고 블루
                        secondary: '#F3F4F6', // 부드러운 밝은 회색
                    }
                }
            }
        }
    </script>
    <style>
        /* 부드러운 스크롤 및 기본 스타일 설정 */
        body { -webkit-font-smoothing: antialiased; }
        /* 장식용 애니메이션 스타일 */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 leading-relaxed flex flex-col min-h-screen">

    <header class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-primary tracking-tight">
                PHP Brand.
            </a>
            <nav class="hidden md:flex space-x-8 font-medium text-gray-600">
                <a href="#home" class="hover:text-primary transition">홈</a>
                <a href="#features" class="hover:text-primary transition">특징</a>
                </nav>
        </div>
    </header>
    ```

---

### 2. `footer.php` (하단 공통 부분)

이 파일에는 웹페이지의 꼬리말이 들어갑니다.

```php
    <footer class="bg-gray-900 text-gray-400 py-12 text-center">
        <div class="container mx-auto px-6">
            <a href="#" class="text-2xl font-bold text-white mb-6 inline-block">PHP Brand.</a>
            <p class="mb-6">PHP로 구성된 깔끔한 웹사이트입니다.</p>
            <p class="text-sm">&copy; <?php echo date("Y"); ?> Clean Web. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>