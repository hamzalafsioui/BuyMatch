<?php
require_once '../../../includes/guards/role.guard.php';
requireRole(2, 3); // Organizer and Admin

$venueRepo = new VenueRepository();
$venues = $venueRepo->getAll();

$currentUser = Auth::getCurrentUser();
$sidebar = ($currentUser->getRoleId() == 3) ? '../../../includes/admin_sidebar.php' : '../../../includes/organizer_sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Venues | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../../assets/js/tailwind.config.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/scroll.css">
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

    <?php include $sidebar; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative">
        <div class="absolute top-[10%] right-[10%] w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-6xl mx-auto w-full">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-black text-white">Venues (Stadiums)</h1>
                <a href="create.php" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-2xl font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> New Venue
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($venues as $venue): ?>
                    <div class="glass border border-slate-700/50 rounded-[2rem] p-6 hover:border-indigo-500/50 transition-all group">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center overflow-hidden border border-slate-700">
                                <i class="fa-solid fa-location-dot text-2xl text-indigo-400"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white"><?php echo htmlspecialchars($venue->getName()); ?></h3>
                                <p class="text-xs text-slate-500 uppercase tracking-widest"><?php echo htmlspecialchars($venue->getCity()); ?></p>
                            </div>
                        </div>
                        <div class="space-y-2 mt-4 pt-4 border-t border-slate-700/30">
                            <div class="flex items-center gap-2 text-sm text-slate-400">
                                <i class="fa-solid fa-map-pin w-4"></i>
                                <span><?php echo htmlspecialchars($venue->getAddress() ?? 'No address provided'); ?></span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-slate-400">
                                <i class="fa-solid fa-users-rectangle w-4"></i>
                                <span>Capacity: <span class="text-white font-bold"><?php echo number_format($venue->getCapacity()); ?></span> seats</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($venues)): ?>
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                            <i class="fa-solid fa-map-location-dot text-3xl text-slate-600"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white mb-2">No Venues Found</h2>
                        <p class="text-slate-400">Get started by adding your first venue.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>