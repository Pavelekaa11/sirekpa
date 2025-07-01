<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wisata Pantai Yogyakarta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .ocean-wave {
            background: linear-gradient(45deg, #0891b2, #0284c7, #0369a1);
            position: relative;
            overflow: hidden;
        }
        .ocean-wave::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255,255,255,0.1) 10px,
                rgba(255,255,255,0.1) 20px
            );
            animation: wave 20s linear infinite;
        }
        @keyframes wave {
            0% { transform: translateX(-50px) translateY(-50px) rotate(0deg); }
            100% { transform: translateX(-50px) translateY(-50px) rotate(360deg); }
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="text-gray-800">
    <nav class="ocean-wave text-white p-6 shadow-lg relative z-10">
        <div class="container mx-auto relative z-10">
            <h1 class="text-2xl font-bold tracking-wide">🏖️ Sistem Rekomendasi Pantai</h1>
            <p class="text-blue-100 text-sm mt-1">Temukan pantai terbaik di Yogyakarta</p>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4">
        <div class="glass-effect rounded-2xl p-6 shadow-xl">
            @yield('content')
        </div>
    </main>

    <div class="fixed bottom-0 left-0 w-full h-32 bg-gradient-to-t from-blue-200 via-blue-100 to-transparent opacity-30 pointer-events-none"></div>
</body>
</html>