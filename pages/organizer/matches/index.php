<?php
// require_once '../../../config/App.php';

require_once '../../../includes/guards/role.guard.php';
requireRole(2);

$matchRepo = new MatchRepository();
$matches = $matchRepo->findByOrganizer($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Matches | BuyMatch</title>
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

    <?php include '../../../includes/organizer_sidebar.php'; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black text-white">My Matches</h1>
            <a href="create.php" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-plus"></i> Create New match
            </a>
        </div>

        <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="py-4 px-4 font-semibold">Match</th>
                            <th class="py-4 px-4 font-semibold">Date</th>
                            <th class="py-4 px-4 font-semibold">Venue</th>
                            <th class="py-4 px-4 font-semibold">Status</th>
                            <th class="py-4 px-4 font-semibold">Request Status</th>
                            <th class="py-4 px-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-300 divide-y divide-slate-800/50">
                        <?php if (empty($matches)): ?>
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500">
                                    No matches found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($matches as $match): ?>
                                <tr class="group hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <span class="font-bold text-white"><?php echo htmlspecialchars($match->homeTeamName); ?></span>
                                            <span class="text-slate-500 text-xs">VS</span>
                                            <span class="font-bold text-white"><?php echo htmlspecialchars($match->awayTeamName); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php echo date('M d, Y • H:i', strtotime($match->matchDatetime)); ?>
                                    </td>
                                    <td class="py-4 px-4 text-slate-400">
                                        <?php echo htmlspecialchars($match->venueName); ?>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php
                                        $statusClass = match ($match->status) {
                                            'PUBLISHED' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'FINISHED' => 'bg-slate-700/50 text-slate-400 border-slate-600/20',
                                            default => 'bg-amber-500/10 text-amber-400 border-amber-500/20'
                                        };
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border <?php echo $statusClass; ?>">
                                            <?php echo $match->status; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php
                                        $requestStatusClass = match ($match->requestStatus) {
                                            'APPROVED' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'REJECTED' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            default => 'bg-amber-500/10 text-amber-400 border-amber-500/20'
                                        };
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border <?php echo $requestStatusClass; ?>">
                                            <?php echo $match->requestStatus; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <?php if ($match->status !== 'FINISHED'): ?>
                                                <?php if ($match->requestStatus === 'APPROVED' && $match->status === 'DRAFT'): ?>
                                                    <button class="publish-match-btn w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-emerald-400 hover:bg-emerald-600 hover:text-white transition-all" data-id="<?php echo $match->matchId; ?>" title="Publish Match">
                                                        <i class="fa-solid fa-rocket"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <a href="edit.php?id=<?php echo $match->matchId; ?>" class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button class="delete-match-btn w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:text-white transition-all" data-id="<?php echo $match->matchId; ?>">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <span class="text-xs text-slate-500 italic">No actions available</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Publish Match
        document.querySelectorAll('.publish-match-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                if (!confirm('Are you sure you want to publish this match? It will be visible to users.')) return;

                const matchId = this.dataset.id;
                const row = this.closest('tr');

                try {
                    const response = await fetch('../../../actions/matches/publish_match.action.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            match_id: matchId
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {

                        location.reload();
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error(error);
                    alert('Network error');
                }
            });
        });

        // Delete Match
        document.querySelectorAll('.delete-match-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                if (!confirm('Are you sure you want to delete this match? This action cannot be undone.')) return;

                const matchId = this.dataset.id;
                const row = this.closest('tr');

                try {
                    const response = await fetch('../../../actions/matches/delete.action.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            match_id: matchId
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        row.remove();

                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error(error);
                    alert('Network error');
                }
            });
        });
    </script>
</body>

</html>