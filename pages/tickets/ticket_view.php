<?php
require_once '../../config/App.php';
Auth::requireLogin();

$userId = $_SESSION['user_id'];
$ticketId = $_GET['id'] ?? null;

if (!$ticketId) {
    header('Location: history.php');
    exit;
}

$ticketRepo = new TicketRepository();
$ticket = $ticketRepo->find($ticketId);
$venueRepo = new VenueRepository();
$venue = $venueRepo->findByTicketId($ticketId);

if (!$ticket || $ticket->getUserId() != $userId) {
    die('Ticket not found or access denied.');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #<?php echo $ticket->getId(); ?> | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .ticket-cut {
            clip-path: polygon(0 0, 100% 0, 100% 70%, 95% 75%, 100% 80%, 100% 100%, 0 100%, 0 80%, 5% 75%, 0 70%);
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
                color: black;
            }

            .ticket-card {
                box-shadow: none;
                border: 2px solid #ddd;
            }
        }
    </style>
</head>

<body class="bg-[#0b0f1a] text-slate-200 min-h-screen flex flex-col items-center p-6 sm:p-12">

    <div class="max-w-md w-full no-print mb-8">
        <a href="history.php" class="text-slate-500 hover:text-white transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i>
            Back to History
        </a>
    </div>

    <!-- Ticket Container -->
    <div class="w-full max-w-sm bg-white text-slate-900 rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-500/10 ticket-card">
        <!-- Header / Match Image (Placeholder) -->
        <div class="h-40 bg-indigo-600 relative overflow-hidden flex items-center justify-center">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-800"></div>
                <div class="w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white/20 to-transparent"></div>
            </div>
            <div class="relative z-10 text-center text-white px-6">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-2 opacity-80">Official Stadium Ticket</p>
                <h1 class="text-2xl font-black italic">
                    <?php echo htmlspecialchars($ticket->getHomeTeamName()); ?> vs <?php echo htmlspecialchars($ticket->getAwayTeamName()); ?>
                </h1>
            </div>
        </div>

        <div class="p-8">
            <!-- Event Details -->
            <div class="space-y-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 flex-shrink-0">
                        <i class="fa-regular fa-calendar text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Date & Time</p>
                        <p class="font-bold text-slate-800"><?php echo date('l, F d, Y', strtotime($ticket->getMatchDatetime())); ?></p>
                        <p class="text-sm text-slate-500"><?php echo date('H:i', strtotime($ticket->getMatchDatetime())); ?> (Local Time)</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <i class="fa-solid fa-location-dot text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Venue</p>

                        <p class="font-bold text-slate-800">
                            <?php echo htmlspecialchars($venue->getName() . ' - ' . $venue->getCity()); ?>
                        </p>
                        <p class="text-sm text-slate-500">
                            <?php echo htmlspecialchars($venue->getAddress()); ?>
                        </p>

                    </div>
                </div>
            </div>

            <!-- Seat & Price Info -->
            <div class="grid grid-cols-2 gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Row/Seat</p>
                    <p class="text-lg font-black text-indigo-600"><?php echo htmlspecialchars($ticket->getSeatId() ?? 'General'); ?></p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Category</p>
                    <p class="text-lg font-bold text-slate-800"><?php echo htmlspecialchars($ticket->getCategoryName() ?? 'Standard'); ?></p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="text-center pt-4 border-t-2 border-dashed border-slate-200">
                <div class="inline-block p-4 bg-white border border-slate-200 rounded-3xl mb-4">
                    <!-- Using a QR code API for real generation -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($ticket->getQrCode()); ?>"
                        alt="QR Code" class="w-32 h-32">
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ticket ID</p>
                <p class="font-mono text-sm tracking-widest text-slate-600"><?php echo $ticket->getQrCode(); ?></p>
            </div>
        </div>

        <!-- Footer / Tear-off effect -->
        <div class="bg-slate-900 p-6 text-center text-white/50 text-[10px] font-bold uppercase tracking-widest">
            This ticket is valid for one entry only
        </div>
    </div>

    <button onclick="window.print()" class="mt-10 no-print px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
        <i class="fa-solid fa-print"></i>
        DOWNLOAD TICKET (PDF)
    </button>

</body>

</html>