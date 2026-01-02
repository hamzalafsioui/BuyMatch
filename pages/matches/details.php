<?php
require_once '../../config/App.php';

$matchId = $_GET['id'] ?? null;
if (!$matchId) {
    header('Location: ../../index.php');
    exit;
}

$matchRepo = new MatchRepository();
$match = $matchRepo->find($matchId);

if (!$match) {
    echo "Match not found."; // 404 Not Implemented Yet
    exit;
}

$teamRepo = new TeamRepository();
$venueRepo = new VenueRepository();

$homeTeam = $teamRepo->find($match['home_team_id']);
$awayTeam = $teamRepo->find($match['away_team_id']);
$venue = $venueRepo->find($match['venue_id']);

$matchDateTime = new DateTime($match['match_datetime']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); }
        .hero-gradient { background: linear-gradient(to bottom, transparent, #0f172a); }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-200">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="../../index.php" class="text-2xl font-black text-white">BuyMatch</a>
            <a href="../../index.php" class="text-indigo-400 hover:text-white transition gap-2 flex items-center">
                <i class="fa-solid fa-arrow-left"></i> Back to Matches
            </a>
        </div>
    </nav>

    <!-- Header / Match Banner -->
    <header class="relative h-[60vh] flex items-center justify-center pt-20 overflow-hidden">
        <!-- Dynamic Background based on Venue or defaults -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522778119026-d647f0565c6a?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center brightness-[0.4]"></div>
        <div class="absolute inset-0 hero-gradient"></div>

        <div class="relative z-10 text-center w-full max-w-5xl px-6">
            <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 mb-8">
                <!-- Home Team -->
                <div class="flex flex-col items-center gap-4">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white/10 rounded-full p-4 flex items-center justify-center backdrop-blur-sm border border-white/10">
                         <?php if (!empty($homeTeam['logo'])): ?>
                            <img src="../../assets/img/uploads/logos/<?php echo htmlspecialchars($homeTeam['logo']); ?>" class="w-full h-full object-contain" alt="Home">
                        <?php else: ?>
                            <span class="text-4xl font-black"><?php echo substr($homeTeam['name'], 0, 1); ?></span>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-black"><?php echo htmlspecialchars($homeTeam['name']); ?></h2>
                </div>

                <!-- VS -->
                <div class="flex flex-col items-center">
                    <div class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">VS</div>
                    <div class="mt-2 px-4 py-1.5 bg-indigo-600/30 border border-indigo-500/50 rounded-full text-sm font-bold tracking-wider uppercase text-indigo-300">
                        <?php echo $match['status']; ?>
                    </div>
                </div>

                <!-- Away Team -->
                <div class="flex flex-col items-center gap-4">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white/10 rounded-full p-4 flex items-center justify-center backdrop-blur-sm border border-white/10">
                        <?php if (!empty($awayTeam['logo'])): ?>
                            <img src="../../assets/img/uploads/logos/<?php echo htmlspecialchars($awayTeam['logo']); ?>" class="w-full h-full object-contain" alt="Away">
                        <?php else: ?>
                            <span class="text-4xl font-black"><?php echo substr($awayTeam['name'], 0, 1); ?></span>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-black"><?php echo htmlspecialchars($awayTeam['name']); ?></h2>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center gap-6 text-slate-300 font-medium text-lg">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-calendar-check text-indigo-400"></i>
                    <?php echo $matchDateTime->format('l, F j, Y'); ?>
                </div>
                <div class="hidden md:block w-1.5 h-1.5 bg-slate-600 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-clock text-indigo-400"></i>
                    <?php echo $matchDateTime->format('H:i'); ?>
                </div>
                <div class="hidden md:block w-1.5 h-1.5 bg-slate-600 rounded-full"></div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-indigo-400"></i>
                    <?php echo htmlspecialchars($venue['name']); ?>, <?php echo htmlspecialchars($venue['city']); ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Content / Booking -->
    <main class="max-w-4xl mx-auto px-6 py-16 -mt-20 relative z-20">
        <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8 md:p-12 shadow-2xl flex flex-col md:flex-row justify-between items-center gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-2">Standard Ticket</h3>
                <p class="text-slate-400 mb-6 max-w-sm">Experience the thrill live! Standard seating with excellent view.</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-black text-white">50€</span>
                    <span class="text-slate-500">/person</span>
                </div>
            </div>

            <?php if (Auth::isAuthenticated()): ?>
                 <button id="bookBtn" class="w-full md:w-auto px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-lg flex items-center justify-center gap-3">
                    <i class="fa-solid fa-ticket"></i>
                    BOOK TICKET
                </button>
            <?php else: ?>
                <a href="../../pages/auth/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="w-full md:w-auto px-10 py-5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl transition-all text-center">
                    Sign in to Book
                </a>
            <?php endif; ?>
        </div>
    </main>

    <script>
        const bookBtn = document.getElementById('bookBtn');
        if (bookBtn) {
            bookBtn.addEventListener('click', async () => {
                if (!confirm('Confirm purchase for 50€?')) return;

                const originalText = bookBtn.innerHTML;
                bookBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> PROCESSING...';
                bookBtn.disabled = true;

                try {
                    const response = await fetch('../../actions/tickets/book.action.php', {
                        method: 'POST',
                        body: JSON.stringify({ match_id: <?php echo $matchId; ?> }),
                        headers: { 'Content-Type': 'application/json' }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Booking successful! Check "My Tickets".');
                        // Redirect to My Tickets
                         window.location.href = '../buyer/tickets.php';
                    } else {
                        alert(result.message);
                        bookBtn.innerHTML = originalText;
                        bookBtn.disabled = false;
                    }
                } catch (error) {
                    console.error(error);
                    alert('Network error');
                    bookBtn.innerHTML = originalText;
                    bookBtn.disabled = false;
                }
            });
        }
    </script>

</body>
</html>
