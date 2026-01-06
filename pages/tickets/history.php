<?php
require_once '../../config/App.php';

Auth::requireLogin();

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
            <div class="flex items-center gap-6">
                <a href="../../index.php" class="text-slate-400 hover:text-white transition">Matches</a>
                <a href="../profile.php" class="text-slate-400 hover:text-white transition">Profile</a>
                <a href="../../actions/Auth/logout.action.php" class="text-red-400 hover:text-red-300 transition">Log Out</a>
            </div>
        </div>
    </nav>

    <main class="pt-28 pb-20 px-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black text-white mb-2">My Tickets</h1>
                <p class="text-slate-400">Manage and view your stadium tickets</p>
            </div>
            <div class="bg-indigo-500/10 border border-indigo-500/20 px-4 py-2 rounded-xl">
                <span class="text-indigo-400 font-bold"><?php echo count($tickets); ?> Total Tickets</span>
            </div>
        </div>

        <?php if (empty($tickets)): ?>
            <div class="glass rounded-3xl p-20 text-center border border-slate-700/50">
                <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-ticket-simple text-3xl text-slate-500"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">No tickets found</h2>
                <p class="text-slate-400 mb-8">You haven't booked any matches yet.</p>
                <a href="../../index.php" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl transition">
                    Browse Matches
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($tickets as $ticket): ?>
                    <div class="glass border border-slate-700/50 rounded-3xl overflow-hidden hover:border-indigo-500/50 transition-all group">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-500/20 uppercase tracking-widest">
                                    <?php echo $ticket->status; ?>
                                </span>
                                <span class="text-slate-500 text-xs">#<?php echo str_pad((string)$ticket->ticketId, 6, '0', STR_PAD_LEFT); ?></span>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-xl font-black text-white group-hover:text-indigo-400 transition">
                                    <?php echo htmlspecialchars($ticket->homeTeamName); ?>
                                    <span class="text-slate-500 font-normal mx-2">VS</span>
                                    <?php echo htmlspecialchars($ticket->awayTeamName); ?>
                                </h3>
                                <p class="text-slate-400 text-sm mt-1">
                                    <i class="fa-calendar-days fa-regular mr-2"></i>
                                    <?php echo date('M d, Y - H:i', strtotime($ticket->matchDatetime)); ?>
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6 bg-slate-900/50 p-4 rounded-2xl border border-slate-700/30">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Seat ID</p>
                                    <p class="text-white font-bold"><?php echo htmlspecialchars($ticket->seatId ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase">Price</p>
                                    <p class="text-indigo-400 font-black"><?php echo number_format($ticket->pricePaid, 2); ?>€</p>
                                </div>
                            </div>

                            <a href="ticket_view.php?id=<?php echo $ticket->ticketId; ?>"
                                class="w-full py-3 bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold rounded-xl transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-expand"></i>
                                View Ticket Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>