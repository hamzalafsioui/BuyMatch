<?php
require_once '../../config/App.php';

if (!Auth::isAuthenticated()) {
    header('Location: ../../pages/auth/login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$ticketRepo = new TicketRepository();
$tickets = $ticketRepo->findByUserId($userId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets | BuyMatch</title>
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
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200">

    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="../../index.php" class="text-2xl font-black text-white">BuyMatch</a>
            <div class="flex items-center gap-4">
                <a href="../../index.php" class="text-slate-400 hover:text-white transition">Browse Matches</a>
                <span class="text-slate-600">|</span>
                <a href="../../actions/Auth/logout.action.php" class="text-red-400 hover:text-red-300 transition">Log Out</a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-32">
        <h1 class="text-3xl font-black text-white mb-8 border-l-4 border-indigo-500 pl-4">My Tickets</h1>

        <div class="space-y-6">
            <?php if (empty($tickets)): ?>
                <div class="glass border border-slate-700/50 rounded-2xl p-8 text-center">
                    <p class="text-slate-400 text-lg mb-4">You haven't booked any tickets yet.</p>
                    <a href="../../index.php" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition">Browse Matches</a>
                </div>
            <?php else: ?>
                <?php foreach ($tickets as $ticket): ?>
                    <div class="glass border border-slate-700/50 rounded-3xl p-0 overflow-hidden flex flex-col md:flex-row shadow-lg hover:border-indigo-500/30 transition-all group">
                        <!-- Left: Details -->
                        <div class="p-8 flex-1">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-bold border border-emerald-500/20">CONFIRMED</span>
                                <span class="text-slate-500 text-sm">#<?php echo substr((string)$ticket->getId(), 0, 8); ?></span>
                            </div>

                            <div class="flex items-center justify-between gap-8 mb-6">
                                <div class="text-center md:text-left">
                                    <h3 class="text-2xl font-black text-white"><?php echo htmlspecialchars($ticket->getHomeTeamName()); ?></h3>
                                </div>
                                <div class="text-slate-500 font-bold text-xl">VS</div>
                                <div class="text-center md:text-right">
                                    <h3 class="text-2xl font-black text-white"><?php echo htmlspecialchars($ticket->getAwayTeamName()); ?></h3>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 text-slate-400 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-indigo-400"></i>
                                    <?php echo date('d M Y', strtotime($ticket->getMatchDatetime())); ?>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-clock text-indigo-400"></i>
                                    <?php echo date('H:i', strtotime($ticket->getMatchDatetime())); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Right: QR Code / Ticket Stub -->
                        <div class="bg-indigo-600 p-8 flex flex-col items-center justify-center text-center w-full md:w-48 relative overflow-hidden">
                            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
                            <!-- Mock QR Code -->
                            <div class="bg-white p-2 rounded-lg mb-2">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo urlencode($ticket->getQrCode()); ?>" alt="QR" class="w-16 h-16">
                            </div>
                            <span class="text-indigo-200 text-xs font-mono uppercase">Scan at Gate</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>