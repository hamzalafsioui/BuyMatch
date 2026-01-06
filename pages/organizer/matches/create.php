<?php
require_once '../../../config/App.php';

$currentUser = Auth::getCurrentUser();
if (!$currentUser || $currentUser->getRoleId() != 2) {
    header('Location: ../../pages/auth/login.php');
    exit;
}

$teamRepo = new TeamRepository();
$venueRepo = new VenueRepository();

$teams = $teamRepo->getAll();
$venues = $venueRepo->getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Match | BuyMatch</title>
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

    <?php include '../../../includes/organizer_sidebar.php'; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative flex flex-col justify-center">
        <!-- Background Elements -->
        <div class="absolute top-[10%] right-[10%] w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-4xl mx-auto w-full">
            <h1 class="text-3xl font-black text-white mb-8">Create New Match</h1>

            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-10 shadow-2xl">
                <form id="createMatchForm" class="space-y-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Home Team -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Home Team</label>
                            <div class="relative">
                                <select name="home_team_id" required class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none appearance-none transition-all">
                                    <option value="" disabled selected>Select Home Team</option>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo $team->getId(); ?>"><?php echo htmlspecialchars($team->getName()); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Away Team -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Away Team</label>
                            <div class="relative">
                                <select name="away_team_id" required class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-purple-500/50 outline-none appearance-none transition-all">
                                    <option value="" disabled selected>Select Away Team</option>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo $team->getId(); ?>"><?php echo htmlspecialchars($team->getName()); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Venue -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Venue (Stadium)</label>
                            <div class="relative">
                                <select name="venue_id" required class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none appearance-none transition-all">
                                    <option value="" disabled selected>Select Venue</option>
                                    <?php foreach ($venues as $venue): ?>
                                        <option value="<?php echo $venue->getId(); ?>"><?php echo htmlspecialchars($venue->getName()); ?> (<?php echo htmlspecialchars($venue->getCity()); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Match Date & Time</label>
                            <input type="datetime-local" name="match_date" required
                                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all [&::-webkit-calendar-picker-indicator]:invert">
                        </div>

                        <!-- Duration -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Duration (minutes)</label>
                            <input type="number" name="duration_min" required placeholder="90" min="1" value="90"
                                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                        </div>
                        <!-- Seats -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase ml-2">Total Seats Available</label>
                            <input type="number" name="total_seats" required placeholder="2000" max="2001" min="1"
                                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                        </div>
                    </div>

                    <!-- Seat Categories -->
                    <div class="space-y-6">
                        <div class="flex justify-between items-center ml-2">
                            <label class="text-xs font-bold text-slate-500 uppercase">Seat Categories & Pricing</label>
                            <button type="button" id="addCategoryBtn" class="text-indigo-400 hover:text-indigo-300 text-xs font-bold uppercase flex items-center gap-2 transition-colors">
                                <i class="fa-solid fa-plus-circle"></i> Add Category
                            </button>
                        </div>

                        <div id="categoriesContainer" class="space-y-4">
                            <div class="category-row grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-800/20 p-6 rounded-2xl border border-slate-700/30">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-600 uppercase ml-1">Category Name</label>
                                    <input type="text" name="category_names[]" required placeholder="For example: VIP, Standard, Economy"
                                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                                </div>
                                <div class="space-y-2 relative">
                                    <label class="text-[10px] font-bold text-slate-600 uppercase ml-1">Price (€)</label>
                                    <div class="flex gap-2">
                                        <input type="number" name="category_prices[]" required placeholder="50.00" min="0" step="0.01"
                                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                                        <button type="button" class="remove-category-btn px-4 text-slate-500 hover:text-red-400 transition-colors">
                                            <i class="fa-solid fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="pt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-sm flex items-center justify-center gap-3">
                            <i class="fa-solid fa-plus"></i>
                            CREATE MATCH
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Dynamic Categories
        const container = document.getElementById('categoriesContainer');
        const addBtn = document.getElementById('addCategoryBtn');

        addBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'category-row grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-800/20 p-6 rounded-2xl border border-slate-700/30 animate-fade-in';
            row.innerHTML = `
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-600 uppercase ml-1">Category Name</label>
                    <input type="text" name="category_names[]" required placeholder="e.g. VIP, Standard"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                </div>
                <div class="space-y-2 relative">
                    <label class="text-[10px] font-bold text-slate-600 uppercase ml-1">Price (€)</label>
                    <div class="flex gap-2">
                        <input type="number" name="category_prices[]" required placeholder="50.00" min="0" step="0.01"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all">
                        <button type="button" class="remove-category-btn px-4 text-slate-500 hover:text-red-400 transition-colors">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(row);
        });

        container.addEventListener('click', (e) => {
            if (e.target.closest('.remove-category-btn')) {
                const rows = container.querySelectorAll('.category-row');
                if (rows.length > 1) {
                    e.target.closest('.category-row').remove();
                } else {
                    alert('At least one category is required.');
                }
            }
        });

        document.getElementById('createMatchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> CREATING...';
            btn.disabled = true;

            try {
                const response = await fetch('../../../actions/matches/create.action.php', {
                    method: 'POST',
                    body: formData
                });


                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('SERVER ERROR:', text);
                    alert('An error occurred. Check console.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    return;
                }

                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    alert(result.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('Network error');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>