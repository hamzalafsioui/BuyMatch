<?php
require_once './config/App.php';

$matchRepo = new MatchRepository();
$matches = $matchRepo->getAllPublished();
$oldMatches = $matchRepo->getAllFinished();


?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch | Premium Sports Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .text-gradient {
            background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-[#0f172a] text-slate-200 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-3xl font-extrabold tracking-tighter">
                <span class="text-gradient">BuyMatch</span>
            </a>
            <div class="space-x-8 text-sm font-medium uppercase tracking-widest hidden md:flex">
                <a href="#" class="hover:text-indigo-400 transition">Events</a>
                <a href="#" class="hover:text-indigo-400 transition">Organizers</a>
                <a href="#" class="hover:text-indigo-400 transition">About</a>
            </div>
            <div class="flex items-center space-x-4">
                <?php if (Auth::isAuthenticated()): ?>
                    <a href="pages/tickets/history.php" class="text-sm font-semibold hover:text-indigo-400 transition">My Tickets</a>
                    <a href="pages/profile.php" class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/20 hover:scale-110 transition-transform">
                        <?php echo substr($_SESSION['user_firstname'] ?? 'U', 0, 1); ?>
                    </a>
                <?php else: ?>
                    <a href="pages/auth/login.php" class="text-sm font-semibold hover:text-white transition">Sign In</a>
                    <a href="pages/auth/register.php" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative min-h-screen flex items-center pt-20">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center brightness-[0.3]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/50 via-transparent to-[#0f172a]"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-8xl font-black mb-6 leading-tight animate-fade-in-up">
                Feel the Thrill of <span class="text-gradient underline decoration-indigo-500/30">Live Sports</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Book your seats for the biggest sporting events in just a few clicks. Security, speed, and passion guaranteed.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#matchs" class="px-8 py-4 bg-white text-[#0f172a] rounded-full text-lg font-bold hover:bg-slate-100 transition shadow-xl shadow-white/5">Explore Matches</a>
                <a href="#" class="px-8 py-4 glass border border-slate-500/30 rounded-full text-lg font-bold hover:bg-white/10 transition">Become an Organizer</a>
            </div>
        </div>
    </header>

    <!-- Featured Matches -->
    <section id="matchs" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Upcoming Matches</h2>
                <div class="h-1.5 w-20 bg-indigo-600 rounded-full"></div>
            </div>

            <!-- Filter Bar -->
            <div class="flex-1 max-w-md w-full relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                <input type="text" id="matchFilter" placeholder="Search by team, venue or city..."
                    class="w-full bg-slate-800/50 border border-slate-700/50 rounded-2xl py-3 pl-12 pr-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-500">
            </div>

            <a href="#" class="text-indigo-400 font-semibold hover:underline hidden md:block">View All →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            if (empty($matches)): ?>
                <div class="col-span-full text-center py-12 text-slate-500">
                    <p class="text-xl">No upcoming matches scheduled yet.</p>
                </div>
            <?php else: ?>
                <?php foreach ($matches as $match): ?>
                    <div class="match-card group bg-slate-800/50 border border-slate-700/50 rounded-3xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 transform hover:-translate-y-2"
                        data-search="<?php echo strtolower($match->homeTeamName . ' ' . $match->awayTeamName . ' ' . $match->venueName . ' ' . $match->venueCity); ?>">
                        <div class="h-48 overflow-hidden relative bg-slate-900 flex items-center justify-center p-4 gap-4">
                            <!-- Logos -->
                            <div class="w-20 h-20 rounded-full bg-white/10 p-2 flex items-center justify-center">
                                <?php if ($match->homeTeamLogo): ?>
                                    <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($match->homeTeamLogo); ?>" class="w-full h-full object-contain rounded-full" alt="Home">
                                <?php else: ?>
                                    <span class="font-bold text-xl"><?php echo substr($match->homeTeamName, 0, 1); ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="text-xl font-bold text-slate-500">VS</span>
                            <div class="w-20 h-20 rounded-full bg-white/10 p-2 flex items-center justify-center">
                                <?php if ($match->awayTeamLogo): ?>
                                    <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($match->awayTeamLogo); ?>" class="w-full h-full object-contain rounded-full" alt="Away">
                                <?php else: ?>
                                    <span class="font-bold text-xl"><?php echo substr($match->awayTeamName, 0, 1); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="absolute top-4 left-4 glass px-3 py-1 rounded-full text-xs font-bold uppercase">Football</div>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-indigo-400 font-bold mb-2">
                                <?php echo date('d M Y • H:i', strtotime($match->matchDatetime)); ?>
                            </div>
                            <h3 class="text-xl font-bold mb-4">
                                <?php echo htmlspecialchars($match->homeTeamName); ?> vs <?php echo htmlspecialchars($match->awayTeamName); ?>
                            </h3>
                            <div class="flex items-center text-slate-400 text-sm mb-6">
                                <i class="fa-solid fa-location-dot w-4 h-4 mr-2"></i>
                                <?php echo htmlspecialchars($match->venueName); ?>, <?php echo htmlspecialchars($match->venueCity); ?>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-black text-white">
                                    <?php
                                    $catRepo = new SeatCategoryRepository();
                                    $matchCats = $catRepo->findByMatchId($match->matchId);
                                    $minPrice = !empty($matchCats) ? min(array_map(fn($c) => $c->getPrice(), $matchCats)) : 0;
                                    echo number_format($minPrice, 2);
                                    ?>$ <span class="text-xs text-slate-500 font-normal">/seat</span>
                                </span>
                                <a href="pages/matches/details.php?id=<?php echo $match->matchId; ?>" class="px-5 py-2 bg-indigo-600 rounded-xl text-sm font-bold border border-indigo-400 group-hover:bg-white group-hover:text-indigo-600 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Old Matches Section -->
    <?php if (!empty($oldMatches)): ?>
        <section class="py-24 px-6 max-w-7xl mx-auto border-t border-slate-800/50">
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4 opacity-70">Old Matches</h2>
                <div class="h-1.5 w-20 bg-slate-600 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($oldMatches as $match): ?>
                    <div class="bg-slate-800/20 border border-slate-800/50 rounded-2xl p-6 grayscale transition-all hover:grayscale-0 hover:bg-slate-800/30">
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Finished</span>
                                <span class="text-[10px] text-slate-600 font-bold"><?php echo date('d M Y', strtotime($match->matchDatetime)); ?></span>
                            </div>
                            <div class="flex items-center justify-center gap-4 py-2">
                                <?php if ($match->homeTeamLogo): ?>
                                    <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($match->homeTeamLogo); ?>" class="w-10 h-10 object-contain" alt="Home">
                                <?php endif; ?>
                                <span class="text-xs font-bold text-slate-600">VS</span>
                                <?php if ($match->awayTeamLogo): ?>
                                    <img src="<?= BASE_URL . '/assets/img/teams/' . htmlspecialchars($match->awayTeamLogo); ?>" class="w-10 h-10 object-contain" alt="Away">
                                <?php endif; ?>
                            </div>
                            <h3 class="text-center font-bold text-slate-400 text-sm">
                                <?php echo htmlspecialchars($match->homeTeamName); ?> vs <?php echo htmlspecialchars($match->awayTeamName); ?>
                            </h3>
                            <div class="text-center text-[11px] text-slate-600 mb-4">
                                <i class="fa-solid fa-location-dot mr-1"></i> <?php echo htmlspecialchars($match->venueName); ?>
                            </div>
                            <button onclick="openReviewModal(<?= $match->matchId ?>)" class="w-full py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                                <i class="fa-solid fa-comments"></i> Reviews
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="closeReviewModal()"></div>
        <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-[#0f172a] border-l border-slate-800 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300" id="reviewPanel">
            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Match Reviews</h2>
                <button onclick="closeReviewModal()" class="text-slate-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Reviews Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6" id="reviewsContainer">
                <div class="flex items-center justify-center h-40">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-indigo-500"></i>
                </div>
            </div>

            <!-- Add Review Form (Hidden by default) -->
            <div id="addReviewSection" class="p-6 border-t border-slate-800 bg-slate-900/30 hidden">
                <h3 class="text-sm font-bold text-white mb-4 uppercase tracking-widest">Add Your Review</h3>
                <form id="addReviewForm" class="space-y-4">
                    <input type="hidden" name="match_id" id="modalMatchId">
                    <div class="flex gap-2" id="starSelection">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-solid fa-star text-2xl cursor-pointer text-slate-700 hover:text-amber-400 transition-colors" data-value="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <textarea name="comment" required placeholder="Write your feedback..."
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl p-4 text-white text-sm focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-600 resize-none h-24"></textarea>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                        Submit Review
                    </button>
                </form>
            </div>
            <div id="loginToReview" class="p-6 border-t border-slate-800 bg-slate-900/30 text-center hidden">
                <p class="text-slate-500 text-sm mb-4">You need to have attended this match to leave a review.</p>
                <a href="pages/auth/login.php" class="inline-block text-indigo-400 font-bold hover:underline">Sign in to share your experience</a>
            </div>
        </div>
    </div>

    <script>
        // Match filtering
        document.getElementById('matchFilter').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.match-card');

            cards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Review Modal Logic
        const modal = document.getElementById('reviewModal');
        const panel = document.getElementById('reviewPanel');
        const reviewsContainer = document.getElementById('reviewsContainer');
        const addReviewSection = document.getElementById('addReviewSection');
        const loginToReview = document.getElementById('loginToReview');
        const addReviewForm = document.getElementById('addReviewForm');
        let selectedRating = 0;

        async function openReviewModal(matchId) {
            document.getElementById('modalMatchId').value = matchId;
            modal.classList.remove('hidden');
            setTimeout(() => panel.classList.remove('translate-x-full'), 10);

            reviewsContainer.innerHTML = '<div class="flex items-center justify-center h-40"><i class="fa-solid fa-spinner fa-spin text-2xl text-indigo-500"></i></div>';
            addReviewSection.classList.add('hidden');
            loginToReview.classList.add('hidden');

            try {
                const response = await fetch(`actions/matches/get_reviews.action.php?match_id=${matchId}`);
                const data = await response.json();

                if (data.success) {
                    renderReviews(data.reviews);
                    if (data.can_review) {
                        addReviewSection.classList.remove('hidden');
                    } else if (!data.is_logged_in) {
                        loginToReview.classList.remove('hidden');
                    }
                }
            } catch (error) {
                reviewsContainer.innerHTML = '<p class="text-red-400 text-center">Failed to load reviews.</p>';
            }
        }

        function renderReviews(reviews) {
            if (reviews.length === 0) {
                reviewsContainer.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fa-solid fa-comment-slash text-4xl text-slate-800 mb-4"></i>
                        <p class="text-slate-500">No reviews yet for this match.</p>
                    </div>`;
                return;
            }

            reviewsContainer.innerHTML = reviews.map(rev => `
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-2xl p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="font-bold text-white block text-sm">${rev.username}</span>
                            <span class="text-[10px] text-slate-500">${rev.date}</span>
                        </div>
                        <div class="flex text-amber-400 text-[10px]">
                            ${Array(5).fill(0).map((_, i) => `<i class="fa-solid fa-star ${i < rev.rating ? '' : 'text-slate-700'}"></i>`).join('')}
                        </div>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed">${rev.comment}</p>
                </div>
            `).join('');
        }

        function closeReviewModal() {
            panel.classList.add('translate-x-full');
            setTimeout(() => modal.classList.add('hidden'), 300);
            resetForm();
        }

        function resetForm() {
            addReviewForm.reset();
            selectedRating = 0;
            updateStars(0);
        }

        // Star selection
        document.querySelectorAll('#starSelection i').forEach(star => {
            star.addEventListener('click', () => {
                selectedRating = parseInt(star.dataset.value);
                updateStars(selectedRating);
            });
            star.addEventListener('mouseenter', () => updateStars(parseInt(star.dataset.value)));
            star.addEventListener('mouseleave', () => updateStars(selectedRating));
        });

        function updateStars(val) {
            document.querySelectorAll('#starSelection i').forEach((s, i) => {
                if (i < val) {
                    s.classList.remove('text-slate-700');
                    s.classList.add('text-amber-400');
                } else {
                    s.classList.remove('text-amber-400');
                    s.classList.add('text-slate-700');
                }
            });
        }

        addReviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (selectedRating === 0) return alert('Please select a rating');

            const matchId = document.getElementById('modalMatchId').value;
            const comment = addReviewForm.comment.value;
            const btn = addReviewForm.querySelector('button');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';

            try {
                const response = await fetch('actions/matches/review.action.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        match_id: matchId,
                        rating: selectedRating,
                        comment: comment
                    })
                });
                const data = await response.json();
                if (data.success) {
                    openReviewModal(matchId); // Refresh reviews
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Connection error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Submit Review';
            }
        });
    </script>

    <footer class="border-t border-slate-800 bg-[#070b14] py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-2xl font-black text-gradient">BuyMatch</div>
            <div class="flex gap-8 text-slate-500 text-sm">
                <a href="#" class="hover:text-indigo-400 transition">Legal Notice</a>
                <a href="#" class="hover:text-indigo-400 transition">Terms of Service</a>
                <a href="#" class="hover:text-indigo-400 transition">Support</a>
            </div>
            <div class="text-slate-500 text-sm">© 2025 BuyMatch. Built for Passion.</div>
        </div>
    </footer>
</body>

</html>