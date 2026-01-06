<?php
require_once '../../config/App.php';

// Ensure user is logged in and is an organizer
$currentUser = Auth::getCurrentUser();
if (!$currentUser || $currentUser->getRoleId() != 2) {
    header('Location: ../../pages/auth/login.php');
    exit;
}

// Get Stats and Recent Activity
$matchRepo = new MatchRepository();
$stats = $matchRepo->getStats($_SESSION['user_id']);

$userRepo = new UserRepository();
$userProfile = $userRepo->find($_SESSION['user_id']);

$recentMatches = $matchRepo->findByOrganizer($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard | BuyMatch</title>
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

    <?php include '../../includes/organizer_sidebar.php'; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative">
        <!-- Background Elements -->
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>
        <div class="absolute bottom-0 left-64 w-[300px] h-[300px] bg-purple-600/10 rounded-full blur-[100px] -z-10"></div>

        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black text-white mb-2">Dashboard</h1>
                <p class="text-slate-400">Welcome back, <span class="text-indigo-400"><?php echo htmlspecialchars($currentUser->getFirstname()); ?></span></p>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 transition-colors relative">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 p-0.5">
                    <img src="<?php echo BASE_URL . '/assets/img/uploads/profiles/' . ($currentUser->getImgPath() ?: 'default.png'); ?>" class="w-full h-full rounded-full object-cover border-2 border-[#0f172a]" alt="Profile">
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Stat Card 1 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/20 rounded-full group-hover:bg-indigo-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 mb-4 text-xl">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Total Matches</h3>
                        <p class="text-3xl font-black text-white"><?php echo $stats['total_matches']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/20 rounded-full group-hover:bg-purple-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-2xl flex items-center justify-center text-purple-400 mb-4 text-xl">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Upcoming</h3>
                        <p class="text-3xl font-black text-white"><?php echo $stats['upcoming_matches']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="glass border border-slate-700/50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/20 rounded-full group-hover:bg-emerald-500/30 transition-all blur-xl"></div>
                <div class="flex flex-col h-full justify-between relative z-10">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 mb-4 text-xl">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-400 font-semibold mb-1">Tickets Sold</h3>
                        <p class="text-3xl font-black text-white"><?php echo $stats['total_seats_sold']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Matches -->
        <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Recent Matches</h2>
                <a href="matches/index.php" class="text-sm font-bold text-indigo-400 hover:text-indigo-300 transition-colors">View All</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="py-4 px-4 font-semibold">Match</th>
                            <th class="py-4 px-4 font-semibold">Date</th>
                            <th class="py-4 px-4 font-semibold">Venue</th>
                            <th class="py-4 px-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-300 divide-y divide-slate-800/50">
                        <?php if (empty($recentMatches)): ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    No matches found. Start by creating one!
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach (array_slice($recentMatches, 0, 5) as $match): ?>
                                <tr class="group hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-white"><?php echo htmlspecialchars($match->homeTeamName); ?></span>
                                            <span class="text-slate-500 text-xs">VS</span>
                                            <span class="font-bold text-white"><?php echo htmlspecialchars($match->awayTeamName); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php echo date('M d, Y • H:i', strtotime($match->matchDatetime)); ?>
                                    </td>
                                    <td class="py-4 px-4 text-slate-400">
                                        <?php echo htmlspecialchars($match->venueName); ?>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php
                                        $statusClass = match ($match->status) {
                                            'PUBLISHED' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'FINISHED' => 'bg-slate-700/50 text-slate-400 border-slate-600/20',
                                            default => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20'
                                        };
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border <?php echo $statusClass; ?>">
                                            <?php echo $match->status; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Not Implemented Yet
        // Simple Sidebar Toggle for Mobile
        // In a real app we'd add the hamburger menu button
    </script>
</body>

</html>