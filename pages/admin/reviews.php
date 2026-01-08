<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';


requireRole(3);

$reviewRepo = new ReviewRepository();
$reviews = $reviewRepo->getAllForAdmin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Management | BuyMatch</title>
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
            <h1 class="text-3xl font-black text-white">Review Management</h1>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-6 py-4 rounded-2xl mb-6 font-semibold">
                <?= htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($reviews)): ?>
            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-12 text-center">
                <div class="w-20 h-20 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 mx-auto mb-6">
                    <i class="fa-solid fa-comments text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No reviews found</h3>
                <p class="text-slate-400">Customer reviews will appear here once matches are finished.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($reviews as $review): ?>
                    <div class="glass border border-slate-700/50 rounded-[2rem] p-6 hover:border-indigo-500/30 transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/30">
                                    <i class="fa-solid fa-user text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-white"><?= htmlspecialchars($review['firstname'] . ' ' . $review['lastname']); ?></p>
                                    <p class="text-xs text-slate-400"><?= date('M d, Y', strtotime($review['created_at'])); ?></p>
                                </div>
                            </div>
                            <div class="text-amber-400 flex items-center gap-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-<?= $i <= $review['rating'] ? 'solid' : 'regular'; ?> fa-star text-sm"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4 class="text-sm font-bold text-indigo-400 mb-2">
                                <?= $review['home_team']; ?> <span class="text-slate-500 text-xs">VS</span> <?= $review['away_team']; ?>
                            </h4>
                            <p class="text-slate-300 text-sm leading-relaxed">"<?= htmlspecialchars($review['comment']); ?>"</p>
                        </div>
                        <div class="flex justify-end pt-4 border-t border-slate-700/50">
                            <form action="<?= BASE_URL; ?>/actions/admin_actions.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                <input type="hidden" name="action" value="delete_review">
                                <input type="hidden" name="review_id" value="<?= $review['id']; ?>">
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm font-bold flex items-center gap-2 transition-colors">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Delete Review
                                </button>
                            </form>
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