<?php
require_once '../../../includes/guards/role.guard.php';
requireRole(2);

$teamRepo = new TeamRepository();
$teams = $teamRepo->getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../../assets/js/tailwind.config.js"></script>
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

    <?php include '../../../includes/organizer_sidebar.php'; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative">
        <div class="absolute top-[10%] right-[10%] w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-6xl mx-auto w-full">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-black text-white">Teams</h1>
                <a href="create.php" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> New Team
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($teams as $team): ?>
                    <div class="glass border border-slate-700/50 rounded-[2rem] p-6 hover:border-indigo-500/50 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-700">
                                <?php if ($team->getLogo()): ?>
                                    <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($team->getLogo()); ?>"
                                        alt="<?php echo htmlspecialchars($team->getName()); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fa-solid fa-futbol text-2xl text-slate-600"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white"><?php echo htmlspecialchars($team->getName()); ?></h3>
                                <p class="text-xs text-slate-500 uppercase tracking-widest">ID: #<?php echo $team->getId(); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($teams)): ?>
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                            <i class="fa-solid fa-users text-3xl text-slate-600"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white mb-2">No Teams Found</h2>
                        <p class="text-slate-400">Get started by creating your first team.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>