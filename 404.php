<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
        }

        .text-gradient {
            background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[150px]"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/10 rounded-full blur-[150px]"></div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
        <!-- 404 Icon -->
        <div class="mb-8 float-animation">
            <div class="w-32 h-32 mx-auto bg-indigo-500/20 rounded-full flex items-center justify-center border-4 border-indigo-500/30">
                <i class="fa-solid fa-futbol text-6xl text-indigo-400"></i>
            </div>
        </div>

        <!-- 404 Text -->
        <h1 class="text-8xl md:text-9xl font-black mb-6 text-gradient">
            404
        </h1>

        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Oops! Match Not Found
        </h2>

        <p class="text-lg text-slate-400 mb-8 max-w-2xl mx-auto">
            Looks like this page has been sent off the field. The page you're looking for doesn't exist or has been moved.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/buyMatch'; ?>/index.php" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                <i class="fa-solid fa-home"></i>
                Back to Home
            </a>
            <button onclick="history.back()" class="px-8 py-4 glass border border-slate-700/50 rounded-xl font-bold hover:bg-slate-800/50 transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Go Back
            </button>
        </div>

        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t border-slate-700/50">
            <p class="text-sm text-slate-500 mb-4">You might be looking for:</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <a href="<?= defined('BASE_URL') ? BASE_URL : '/buyMatch'; ?>/index.php" class="text-indigo-400 hover:text-indigo-300 transition">
                    <i class="fa-solid fa-futbol mr-1"></i>Upcoming Matches
                </a>
                <a href="<?= defined('BASE_URL') ? BASE_URL : '/buyMatch'; ?>/pages/auth/login.php" class="text-indigo-400 hover:text-indigo-300 transition">
                    <i class="fa-solid fa-right-to-bracket mr-1"></i>Login
                </a>
                <a href="<?= defined('BASE_URL') ? BASE_URL : '/buyMatch'; ?>/pages/auth/register.php" class="text-indigo-400 hover:text-indigo-300 transition">
                    <i class="fa-solid fa-user-plus mr-1"></i>Register
                </a>
            </div>
        </div>
    </div>

    <script>
        // some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const icon = document.querySelector('.float-animation');
            icon.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(15deg)';
            });
            icon.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    </script>
</body>

</html>