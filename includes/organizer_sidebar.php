<aside class="fixed left-0 top-0 h-screen w-64 glass border-r border-slate-700/50 p-6 flex flex-col z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0" id="sidebar">
    <div class="mb-10 flex items-center gap-3 px-2">
        <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
            BM
        </div>
        <span class="text-xl font-bold bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">BuyMatch</span>
    </div>

    <nav class="flex-1 space-y-2">
        <a href="<?php echo BASE_URL; ?>/pages/organizer/dashboard.php" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all group <?php echo strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : ''; ?>">
            <i class="fa-solid fa-chart-pie w-6 text-center group-hover:scale-110 transition-transform <?php echo strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>
            <span>Dashboard</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Management</div>

        <a href="<?php echo BASE_URL; ?>/pages/organizer/matches/index.php" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all group <?php echo strpos($_SERVER['PHP_SELF'], 'matches/index.php') !== false ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : ''; ?>">
            <i class="fa-solid fa-futbol w-6 text-center group-hover:scale-110 transition-transform <?php echo strpos($_SERVER['PHP_SELF'], 'matches/index.php') !== false ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>
            <span>My Matches</span>
        </a>

        <a href="<?php echo BASE_URL; ?>/pages/organizer/matches/create.php" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all group <?php echo strpos($_SERVER['PHP_SELF'], 'matches/create.php') !== false ? 'bg-indigo-600/10 text-indigo-400 font-semibold' : ''; ?>">
            <i class="fa-solid fa-plus w-6 text-center group-hover:scale-110 transition-transform <?php echo strpos($_SERVER['PHP_SELF'], 'matches/create.php') !== false ? 'text-indigo-400' : 'text-slate-500'; ?>"></i>
            <span>Create Match</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-slate-600 uppercase tracking-wider">Account</div>

        <a href="<?php echo BASE_URL; ?>/pages/profile.php" class="nav-item flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all group">
            <i class="fa-solid fa-user-gear w-6 text-center group-hover:scale-110 transition-transform text-slate-500"></i>
            <span>Profile</span>
        </a>
    </nav>

    <div class="pt-4 border-t border-slate-700/30">
        <a href="<?php echo BASE_URL; ?>/actions/Auth/logout.action.php" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all group">
            <i class="fa-solid fa-right-from-bracket w-6 text-center group-hover:scale-110 transition-transform"></i>
            <span>Log Out</span>
        </a>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden opacity-0 transition-opacity"></div>