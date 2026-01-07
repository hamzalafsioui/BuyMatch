<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';

requireRole(3);

$matchRepo = new MatchRepository();
$requests = $matchRepo->getAllRequests();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Requests | BuyMatch</title>
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
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black text-white">Match Requests</h1>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-6 py-4 rounded-2xl mb-6 font-semibold">
                <?= htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($requests)): ?>
            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-12 text-center">
                <div class="w-20 h-20 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-6">
                    <i class="fa-solid fa-futbol text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No pending requests</h3>
                <p class="text-slate-400">All match requests have been processed.</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($requests as $match): ?>
                    <div class="glass border border-slate-700/50 rounded-[2rem] p-6 hover:border-indigo-500/30 transition-all">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                            <div class="flex items-center gap-6 flex-1">
                                <div class="flex items-center space-x-2">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-800/50 border border-slate-700/50 p-2 hover:scale-105 transition-transform duration-500 overflow-hidden">
                                        <img src="<?= BASE_URL . "/assets/img/uploads/logos/" . $match['home_team_logo']; ?>" alt="<?= $match['home_team_name']; ?>" class="w-full h-full object-contain">
                                    </div>
                                    <div class="w-16 h-16 rounded-2xl bg-slate-800/50 border border-slate-700/50 p-2 hover:scale-105 transition-transform duration-500 overflow-hidden relative z-10">
                                        <img src="<?= BASE_URL .  "/assets/img/uploads/logos/" . $match['away_team_logo']; ?>" alt="<?= $match['away_team_name']; ?>" class="w-full h-full object-contain">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2"><?= $match['home_team_name']; ?> <span class="text-slate-500 text-sm">VS</span> <?= $match['away_team_name']; ?></h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-400">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-location-dot text-indigo-400"></i>
                                            <?= $match['venue_name']; ?>, <?= $match['venue_city']; ?>
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-calendar text-indigo-400"></i>
                                            <?= date('M d, Y • H:i', strtotime($match['match_datetime'])); ?>
                                        </span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-user-tie text-indigo-400"></i>
                                            <?= $match['firstname'] . ' ' . $match['lastname']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <form action="<?= BASE_URL; ?>/actions/admin_actions.php" method="POST" class="flex gap-3">
                                    <input type="hidden" name="action" value="update_match_status">
                                    <input type="hidden" name="match_id" value="<?= $match['id']; ?>">
                                    <button name="status" value="PUBLISHED"
                                        class="px-6 py-3 bg-sky-500/10 text-sky-400 border border-sky-500/20 rounded-xl font-bold hover:bg-sky-600 hover:text-white transition-all shadow-lg shadow-sky-500/10">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>Published
                                    </button>

                                    <button name="status" value="APPROVED" class="px-6 py-3 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl font-bold hover:bg-emerald-600 hover:text-white transition-all shadow-lg shadow-emerald-500/10">
                                        <i class="fa-solid fa-check mr-2"></i>Approve
                                    </button>
                                    <button name="status" value="REJECTED" class="px-6 py-3 bg-red-500/10 text-red-400 border border-red-500/20 rounded-xl font-bold hover:bg-red-600 hover:text-white transition-all shadow-lg shadow-red-500/10">
                                        <i class="fa-solid fa-xmark mr-2"></i>Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>

    </script>
</body>

</html>