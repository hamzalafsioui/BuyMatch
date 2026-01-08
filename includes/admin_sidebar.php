<?php
$currentPage = $_SERVER['PHP_SELF'];

$isDashboard = strpos($currentPage, 'dashboard.php') !== false;
$isUsers     = strpos($currentPage, 'users.php') !== false;
$isMatches   = strpos($currentPage, 'matches.php') !== false;
$isReviews   = strpos($currentPage, 'reviews.php') !== false;
$isTeams     = strpos($currentPage, 'pages/admin/teams') !== false;
$isProfile   = strpos($currentPage, "pages/profile.php") !== false;

?>

<aside class="fixed left-0 top-0 h-screen w-64 glass border-r border-slate-700/50 p-6 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0" id="sidebar">

    <!-- Logo -->
    <div class="mb-10 flex items-center gap-3 px-2">
        <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
            BM
        </div>
        <span class="text-xl font-bold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
            BuyMatch Admin
        </span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-2">

        <!-- Dashboard -->
        <a href="<?= BASE_URL; ?>/pages/admin/dashboard.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group
           <?= $isDashboard ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-chart-pie w-6 text-center transition-transform group-hover:scale-110
            <?= $isDashboard ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>

            <span>Dashboard</span>
        </a>

        <!-- Section -->
        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">
            Management
        </div>

        <!-- Users -->
        <a href="<?= BASE_URL; ?>/pages/admin/users.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group
           <?= $isUsers ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-users w-6 text-center transition-transform group-hover:scale-110
            <?= $isUsers ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>

            <span>Users</span>
        </a>

        <!-- Match Requests -->
        <a href="<?= BASE_URL; ?>/pages/admin/matches.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group
           <?= $isMatches ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-futbol w-6 text-center transition-transform group-hover:scale-110
            <?= $isMatches ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>

            <span>Match Requests</span>
        </a>

        <!-- Reviews -->
        <a href="<?= BASE_URL; ?>/pages/admin/reviews.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group
           <?= $isReviews ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-comments w-6 text-center transition-transform group-hover:scale-110
            <?= $isReviews ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>

            <span>Reviews</span>
        </a>

        <!-- Teams -->
        <a href="<?= BASE_URL; ?>/pages/admin/teams/index.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all group
           <?= $isTeams ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-people-group w-6 text-center transition-transform group-hover:scale-110
            <?= $isTeams ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>

            <span>Teams</span>
        </a>

        <!-- Section -->
        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">
            Account
        </div>

        <!-- Profile -->
        <a href="<?= BASE_URL; ?>/pages/profile.php"
            class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl  hover:bg-slate-800/50 transition-all group
           <?= $isProfile ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'; ?>">

            <i class="fa-solid fa-user-gear w-6 text-center transition-transform group-hover:scale-110
             <?= $isProfile ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>
            <span>Profile</span>
        </a>

    </nav>

    <!-- Logout -->
    <div class="pt-4 border-t border-slate-700/30">
        <a href="<?= BASE_URL; ?>/actions/Auth/logout.action.php"
            class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all group">

            <i class="fa-solid fa-right-from-bracket w-6 text-center transition-transform group-hover:scale-110"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="sidebar-overlay"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden opacity-0 transition-opacity">
</div>