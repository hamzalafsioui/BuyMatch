<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';

requireRole(3);

$userRepo = new UserRepository();
$matchRepo = new MatchRepository();

$userStats = $userRepo->getGlobalStats();
$matchStats = $matchRepo->getGlobalStatsForAdmin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind.config.js"></script>
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
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200">

    <?php include '../../includes/admin_sidebar.php'; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>
        <div class="absolute bottom-0 left-64 w-[300px] h-[300px] bg-purple-600/10 rounded-full blur-[100px] -z-10"></div>

        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-white mb-2">Admin Dashboard</h1>
                <p class="text-slate-400">Total overview of the BuyMatch platform</p>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Stat Card 1 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/20 rounded-full group-hover:bg-indigo-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 mb-4 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Total Users</h3>
                        <p class="text-3xl font-black text-white"><?php echo $userStats['total_users']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/20 rounded-full group-hover:bg-purple-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-2xl flex items-center justify-center text-purple-400 mb-4 text-xl">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Total Organizers</h3>
                        <p class="text-3xl font-black text-white"><?php echo $userStats['total_organizers']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/20 rounded-full group-hover:bg-emerald-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 mb-4 text-xl">
                        <i class="fa-solid fa-futbol"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Total Matches</h3>
                        <p class="text-3xl font-black text-white"><?php echo $matchStats['total_matches']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/20 rounded-full group-hover:bg-amber-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-2xl flex items-center justify-center text-amber-400 mb-4 text-xl">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Total Revenue</h3>
                        <p class="text-3xl font-black text-white"><?php echo number_format($matchStats['total_revenue'], 2); ?> $</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- User Activity -->
            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">User Activity</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-slate-800/30 rounded-2xl hover:bg-slate-800/50 transition-colors">
                        <span class="text-slate-300 font-semibold">Active Users</span>
                        <span class="text-emerald-400 font-black text-xl"><?php echo $userStats['active_users']; ?></span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-slate-800/30 rounded-2xl hover:bg-slate-800/50 transition-colors">
                        <span class="text-slate-300 font-semibold">Inactive Users</span>
                        <span class="text-red-400 font-black text-xl"><?php echo $userStats['total_users'] - $userStats['active_users']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Match Requests -->
            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">Match Requests</h2>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-slate-800/30 rounded-2xl hover:bg-slate-800/50 transition-colors">
                        <span class="text-slate-300 font-semibold">Approved Matches</span>
                        <span class="text-emerald-400 font-black text-xl"><?php echo $matchStats['approved_matches']; ?></span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-slate-800/30 rounded-2xl hover:bg-slate-800/50 transition-colors">
                        <span class="text-slate-300 font-semibold">Pending or Refused</span>
                        <span class="text-amber-400 font-black text-xl"><?php echo $matchStats['total_matches'] - $matchStats['approved_matches']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        
    </script>
</body>

</html>