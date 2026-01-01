<?php
require_once './config/App.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch | Premium Sports Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .text-gradient {
            background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-3xl font-extrabold tracking-tighter">
                <span class="text-gradient">BuyMatch</span>
            </a>
            <div class="space-x-8 text-sm font-medium uppercase tracking-widest hidden md:flex">
                <a href="#" class="hover:text-indigo-400 transition">Events</a>
                <a href="#" class="hover:text-indigo-400 transition">Organizers</a>
                <a href="#" class="hover:text-indigo-400 transition">About</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="pages/auth/login.php" class="text-sm font-semibold hover:text-white transition">Sign In</a>
                <a href="pages/auth/register.php" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center pt-20">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center brightness-[0.3]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/50 via-transparent to-[#0f172a]"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-8xl font-black mb-6 leading-tight animate-fade-in-up">
                Feel the Thrill of <span class="text-gradient underline decoration-indigo-500/30">Live Sports</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Book your seats for the biggest sporting events in just a few clicks. Security, speed, and passion guaranteed.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#matchs" class="px-8 py-4 bg-white text-[#0f172a] rounded-full text-lg font-bold hover:bg-slate-100 transition shadow-xl shadow-white/5">Explore Matches</a>
                <a href="#" class="px-8 py-4 glass border border-slate-500/30 rounded-full text-lg font-bold hover:bg-white/10 transition">Become an Organizer</a>
            </div>
        </div>
    </header>

    <!-- Featured Matches -->
    <section id="matchs" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Upcoming Matches</h2>
                <div class="h-1.5 w-20 bg-indigo-600 rounded-full"></div>
            </div>
            <a href="#" class="text-indigo-400 font-semibold hover:underline">View All →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Placeholder Card 1 -->
            <div class="group bg-slate-800/50 border border-slate-700/50 rounded-3xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 transform hover:-translate-y-2">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1893&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" alt="Match 1">
                    <div class="absolute top-4 left-4 glass px-3 py-1 rounded-full text-xs font-bold uppercase">Football</div>
                </div>
                <div class="p-6">
                    <div class="text-sm text-indigo-400 font-bold mb-2">15 JAN 2026 • 20:45</div>
                    <h3 class="text-xl font-bold mb-4">PSG vs Real Madrid</h3>
                    <div class="flex items-center text-slate-400 text-sm mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Parc des Princes, Paris
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-black text-white">45€ <span class="text-xs text-slate-500 font-normal">/seat</span></span>
                        <a href="#" class="px-5 py-2 bg-indigo-600 rounded-xl text-sm font-bold border border-indigo-400 group-hover:bg-white group-hover:text-indigo-600 transition">Book Now</a>
                    </div>
                </div>
            </div>

            <!-- More placeholders can be added here -->
        </div>
    </section>

    <footer class="border-t border-slate-800 bg-[#070b14] py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-2xl font-black text-gradient">BuyMatch</div>
            <div class="flex gap-8 text-slate-500 text-sm">
                <a href="#" class="hover:text-indigo-400 transition">Legal Notice</a>
                <a href="#" class="hover:text-indigo-400 transition">Terms of Service</a>
                <a href="#" class="hover:text-indigo-400 transition">Support</a>
            </div>
            <div class="text-slate-500 text-sm">© 2025 BuyMatch. Built for Passion.</div>
        </div>
    </footer>
</body>

</html>