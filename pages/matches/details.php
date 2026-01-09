<?php
require_once '../../config/App.php';
// require_once BASE_PATH . DIRECTORY_SEPARATOR . 'actions/matches/details.action.php';
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
$catRepo = new SeatCategoryRepository();
$reviewRepo = new ReviewRepository();

$homeTeam = $teamRepo->find($match->getHomeTeamId());
$awayTeam = $teamRepo->find($match->getAwayTeamId());
$venue = $venueRepo->find($match->getVenueId());
$categories = $catRepo->findByMatchId($matchId);
$reviews = $reviewRepo->findByMatchId($matchId);

$userHasTicket = false;
if (Auth::isAuthenticated()) {
    $ticketRepo = new TicketRepository();
    $userHasTicket = $ticketRepo->countByUserMatch($_SESSION['user_id'], $matchId) > 0;
}

$matchDateTime = new DateTime($match->getMatchDatetime());
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
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
        }

        .hero-gradient {
            background: linear-gradient(to bottom, transparent, #0f172a);
        }

        .category-card.selected {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }
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
                        <?php if ($homeTeam->getLogo()): ?>
                            <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($homeTeam->getLogo()); ?>" class="w-full h-full object-contain rounded-full" alt="Home">
                        <?php else: ?>
                            <span class="text-4xl font-black"><?php echo substr($homeTeam->getName(), 0, 1); ?></span>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-black"><?php echo htmlspecialchars($homeTeam->getName()); ?></h2>
                </div>

                <!-- VS -->
                <div class="flex flex-col items-center">
                    <div class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500">VS</div>
                    <div class="mt-2 px-4 py-1.5 bg-indigo-600/30 border border-indigo-500/50 rounded-full text-sm font-bold tracking-wider uppercase text-indigo-300">
                        <?php echo $match->getStatus(); ?>
                    </div>
                </div>

                <!-- Away Team -->
                <div class="flex flex-col items-center gap-4">
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white/10 rounded-full p-4 flex items-center justify-center backdrop-blur-sm border border-white/10">
                        <?php if ($awayTeam->getLogo()): ?>
                            <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($awayTeam->getLogo()); ?>" class="w-full h-full object-contain rounded-full" alt="Away">
                        <?php else: ?>
                            <span class="text-4xl font-black"><?php echo substr($awayTeam->getName(), 0, 1); ?></span>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-2xl md:text-4xl font-black"><?php echo htmlspecialchars($awayTeam->getName()); ?></h2>
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
                    <?php echo htmlspecialchars($venue->getName()); ?>, <?php echo htmlspecialchars($venue->getCity()); ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Content / Booking -->
    <main class="max-w-5xl mx-auto px-6 py-16 -mt-20 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Seat Selection -->
            <div class="lg:col-span-2 space-y-6">
                <h3 class="text-2xl font-black text-white px-2">Choose Seat Category</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($categories as $cat): ?>
                        <div class="category-card glass border border-slate-700/50 rounded-3xl p-6 cursor-pointer transition-all hover:border-indigo-500/30"
                            data-id="<?php echo $cat->getId(); ?>" data-price="<?php echo $cat->getPrice(); ?>">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-10 h-10 bg-indigo-600/20 rounded-xl flex items-center justify-center text-indigo-400">
                                    <i class="fa-solid fa-chair"></i>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-black text-white"><?php echo number_format($cat->getPrice(), 2); ?>€</div>
                                    <div class="text-xs text-slate-500 uppercase font-bold">Per Seat</div>
                                </div>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2"><?php echo htmlspecialchars($cat->getName()); ?></h4>
                            <p class="text-sm text-slate-400 leading-relaxed">Access to the stadium in the <?php echo strtolower(htmlspecialchars($cat->getName())); ?> section.</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Summary & Payment -->
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-white px-2">Summary</h3>
                <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8 shadow-2xl sticky top-24">
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Match</span>
                            <span class="text-white font-bold text-right"><?php echo htmlspecialchars($homeTeam->getName()); ?> vs <?php echo htmlspecialchars($awayTeam->getName()); ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Category</span>
                            <span id="selectedCat" class="text-indigo-400 font-black">-</span>
                        </div>
                        <div class="space-y-4 pt-4 border-t border-slate-700/50">
                            <label class="block text-sm font-bold text-slate-400 uppercase">Quantity (Max 4)</label>
                            <select id="quantity" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500">
                                <option value="1">1 Ticket</option>
                                <option value="2">2 Tickets</option>
                                <option value="3">3 Tickets</option>
                                <option value="4">4 Tickets</option>
                            </select>
                        </div>
                        <div id="seatsContainer" class="space-y-3 pt-4">
                            <!-- Seat inputs will appear here -->
                        </div>
                        <div class="pt-4 border-t border-slate-700/50 flex justify-between items-end">
                            <span class="text-slate-400">Total Price</span>
                            <span id="totalPrice" class="text-3xl font-black text-white">0.00€</span>
                        </div>
                    </div>

                    <?php if (!Auth::isAuthenticated()): ?>
                        <a href="../auth/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                            class="w-full py-5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-black rounded-3xl shadow-2xl shadow-indigo-500/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 tracking-widest uppercase text-sm">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Sign in to Book
                        </a>
                    <?php else: ?>
                        <button id="bookBtn" disabled class="w-full px-8 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-lg flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fa-solid fa-ticket"></i>
                            BOOK NOW
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-20 border-t border-slate-800 pt-16">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h3 class="text-3xl font-black text-white">Fan Reviews</h3>
                    <p class="text-slate-400">What people are saying about this match</p>
                </div>
                <?php if ($match->getStatus() == 'FINISHED' && $userHasTicket): ?>
                    <button id="addReviewBtn" class="px-6 py-3 bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 font-bold rounded-xl border border-indigo-500/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-star"></i>
                        Leave a Review
                    </button>
                <?php endif; ?>
            </div>

            <!-- Review Form (Hidden by default) -->
            <div id="reviewFormContainer" class="hidden mb-12 glass border border-indigo-500/30 rounded-3xl p-8">
                <form id="reviewForm" class="space-y-6">
                    <input type="hidden" name="match_id" value="<?php echo $matchId; ?>">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-bold text-slate-400 uppercase mb-2">Rating</label>
                            <div class="flex gap-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="<?php echo $i; ?>" class="hidden star-input" required>
                                        <i class="fa-solid fa-star text-2xl text-slate-700 hover:text-amber-400 star-icon transition-colors"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-400 uppercase mb-2">Comment</label>
                        <textarea name="comment" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-2xl px-6 py-4 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-600" placeholder="Share your experience..." required></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" id="cancelReviewBtn" class="px-6 py-3 text-slate-400 font-bold hover:text-white transition">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg transition">Post Review</button>
                    </div>
                </form>
            </div>

            <?php if (empty($reviews)): ?>
                <div class="text-center py-12 bg-slate-800/20 rounded-3xl border border-slate-800">
                    <p class="text-slate-500 italic">No reviews yet. Be the first to share your thoughts!</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($reviews as $review): ?>
                        <div class="glass border border-slate-700/50 rounded-3xl p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center font-bold text-indigo-400">
                                        <?php echo substr($review->firstname, 0, 1) . substr($review->lastname, 0, 1); ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-white"><?php echo htmlspecialchars($review->firstname . ' ' . $review->lastname); ?></p>
                                        <div class="flex text-amber-500 text-[10px] gap-0.5">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <i class="fa-solid fa-star <?php echo $i < $review->rating ? '' : 'opacity-20'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[10px] text-slate-500 font-medium uppercase"><?php echo date('M Y', strtotime($review->createdAt)); ?></span>
                            </div>
                            <p class="text-slate-300 text-sm italic leading-relaxed">
                                "<?php echo htmlspecialchars($review->comment); ?>"
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        let selectedCategoryId = null;
        let selectedPrice = 0;

        const catCards = document.querySelectorAll('.category-card');
        const selectedCatDisplay = document.getElementById('selectedCat');
        const totalPriceDisplay = document.getElementById('totalPrice');
        const quantitySelect = document.getElementById('quantity');
        const seatsContainer = document.getElementById('seatsContainer');
        const bookBtn = document.getElementById('bookBtn');

        function updateSummary() {
            const qty = parseInt(quantitySelect.value);
            const total = selectedPrice * qty;
            totalPriceDisplay.textContent = total.toFixed(2) + '€';

            // Update seat inputs
            seatsContainer.innerHTML = '';
            for (let i = 1; i <= qty; i++) {
                const div = document.createElement('div');
                div.className = 'space-y-1';
                div.innerHTML = `
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Seat Number #${i}</label>
                    <input type="text" placeholder="e.g. A24" class="seat-input w-full bg-slate-900/30 border border-slate-700/30 rounded-lg px-3 py-2 text-white focus:border-indigo-500 outline-none transition-all" required>
                `;
                seatsContainer.appendChild(div);
            }
        }

        catCards.forEach(card => {
            card.addEventListener('click', () => {
                catCards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');

                selectedCategoryId = card.dataset.id;
                selectedPrice = parseFloat(card.dataset.price);

                selectedCatDisplay.textContent = card.querySelector('h4').textContent;
                updateSummary();

                if (bookBtn) bookBtn.disabled = false;
            });
        });

        quantitySelect.addEventListener('change', updateSummary);

        if (bookBtn) {
            bookBtn.addEventListener('click', async () => {
                if (!selectedCategoryId) return;

                const seatInputs = document.querySelectorAll('.seat-input');
                const seats = Array.from(seatInputs).map(inp => inp.value.trim()).filter(v => v !== '');

                if (seats.length < parseInt(quantitySelect.value)) {
                    alert('Please provide all seat numbers.');
                    return;
                }

                if (!confirm(`Confirm purchase for ${quantitySelect.value} ticket(s)? Total: ${totalPriceDisplay.textContent}`)) return;

                const originalText = bookBtn.innerHTML;
                bookBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> PROCESSING...';
                bookBtn.disabled = true;

                try {
                    const response = await fetch('../../actions/tickets/book.action.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            match_id: <?php echo $matchId; ?>,
                            category_id: selectedCategoryId,
                            quantity: parseInt(quantitySelect.value),
                            seats: seats
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert('Booking successful! Check "My Tickets".');
                        window.location.href = '../tickets/history.php';
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

        // --- Reviews JS ---
        const addReviewBtn = document.getElementById('addReviewBtn');
        const reviewFormContainer = document.getElementById('reviewFormContainer');
        const cancelReviewBtn = document.getElementById('cancelReviewBtn');
        const reviewForm = document.getElementById('reviewForm');
        const starInputs = document.querySelectorAll('.star-input');
        const starIcons = document.querySelectorAll('.star-icon');

        if (addReviewBtn) {
            addReviewBtn.addEventListener('click', () => {
                reviewFormContainer.classList.remove('hidden');
                addReviewBtn.classList.add('hidden');
            });
        }

        if (cancelReviewBtn) {
            cancelReviewBtn.addEventListener('click', () => {
                reviewFormContainer.classList.add('hidden');
                addReviewBtn.classList.remove('hidden');
            });
        }

        starInputs.forEach((input, index) => {
            input.addEventListener('change', () => {
                const val = parseInt(input.value);
                starIcons.forEach((icon, i) => {
                    if (i < val) {
                        icon.classList.add('text-amber-400');
                        icon.classList.remove('text-slate-700');
                    } else {
                        icon.classList.remove('text-amber-400');
                        icon.classList.add('text-slate-700');
                    }
                });
            });
        });

        if (reviewForm) {
            reviewForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(reviewForm);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('../../actions/matches/review.action.php', {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        alert('Review posted! Thank you.');
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error posting review.');
                }
            });
        }
    </script>

</body>

</html>