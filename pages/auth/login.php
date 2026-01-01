<?php
require_once "../../config/App.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
        }

        .input-glow:focus {
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
            border-color: rgba(99, 102, 241, 0.5);
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-md glass border border-slate-700/50 rounded-[2.5rem] p-10 shadow-2xl relative z-10 transition-all duration-500 hover:shadow-indigo-500/10">
        <div class="text-center mb-10">
            <a href="../../index.php" class="text-3xl font-black inline-block mb-4">
                <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">BuyMatch</span>
            </a>
            <h2 class="text-2xl font-bold text-white mb-2">Welcome Back!</h2>
            <p class="text-slate-400 text-sm">Ready for your next match?</p>
        </div>

        <form id="loginForm" class="space-y-8">
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase ml-2 tracking-widest">Email Address</label>
                <input type="email" name="email" required placeholder="name@example.com"
                    class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all input-glow placeholder:text-slate-700">
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center ml-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-widest">Password</label>
                    <a href="#" class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest hover:text-indigo-300 transition-colors">Forgot?</a>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all input-glow placeholder:text-slate-700">
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-500 hover:to-indigo-600 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-sm uppercase flex items-center justify-center gap-3">
                <i class="fa-solid fa-right-to-bracket"></i>
                Sign In to Arena
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            Don't have an account?
            <a href="register.php" class="text-indigo-400 font-bold hover:underline">Create an account</a>
        </div>
    </div>

    <script src="../../assets/js/login.js"></script>
</body>

</html>