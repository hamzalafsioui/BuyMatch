<?php
require_once __DIR__ . '/../../config/App.php';
require_once __DIR__ . '/../../includes/guards/role.guard.php';

requireRole(3);

$userRepo = new UserRepository();
$users = $userRepo->getAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | BuyMatch</title>
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
            <h1 class="text-3xl font-black text-white">User Management</h1>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-6 py-4 rounded-2xl mb-6 font-semibold">
                <?= htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-6 py-4 rounded-2xl mb-6 font-semibold">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="glass border border-slate-700/50 rounded-[2.5rem] p-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-700/50 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="py-4 px-4 font-semibold">User</th>
                            <th class="py-4 px-4 font-semibold">Email</th>
                            <th class="py-4 px-4 font-semibold">Role</th>
                            <th class="py-4 px-4 font-semibold">Status</th>
                            <th class="py-4 px-4 font-semibold">Org Status</th>
                            <th class="py-4 px-4 font-semibold">Joined</th>
                            <th class="py-4 px-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-300 divide-y divide-slate-800/50">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-500">
                                    No users found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="group hover:bg-slate-800/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/30 overflow-hidden">
                                                <?php if ($user['img_path']): ?>
                                                    <img src="<?= BASE_URL . '/assets/img/uploads/profiles/' .$user['img_path']; ?>" alt="" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <i class="fa-solid fa-user"></i>
                                                <?php endif; ?>
                                            </div>
                                            <span class="font-bold text-white"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-400"><?= htmlspecialchars($user['email']); ?></td>
                                    <td class="py-4 px-4">
                                        <?php
                                        $roleClass = match ($user['role_name']) {
                                            'ADMIN' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                            'ORGANIZER' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                            default => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                                        };
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border <?= $roleClass; ?>">
                                            <?= $user['role_name']; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="flex items-center gap-2 <?= $user['is_active'] ? 'text-emerald-400' : 'text-red-400'; ?>">
                                            <span class="w-2 h-2 rounded-full <?= $user['is_active'] ? 'bg-emerald-400' : 'bg-red-400'; ?> animate-pulse"></span>
                                            <?= $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php if ($user['role_name'] === 'ORGANIZER'): ?>
                                            <?php if ($user['is_acceptable']): ?>
                                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                                                    <i class="fa-solid fa-check mr-1"></i>Approved
                                                </span>
                                            <?php else: ?>
                                                <span class="px-3 py-1 rounded-full text-xs font-bold border bg-amber-500/10 text-amber-400 border-amber-500/20">
                                                    <i class="fa-solid fa-clock mr-1"></i>Pending
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-slate-600">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-4"><?= date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <?php if ($user['role_name'] !== 'ADMIN'): ?>
                                                <form action="<?= BASE_URL; ?>/actions/admin_actions.php" method="POST" class="inline">
                                                    <input type="hidden" name="action" value="toggle_user_status">
                                                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center <?= $user['is_active'] ? 'text-red-400 hover:bg-red-600' : 'text-emerald-400 hover:bg-emerald-600'; ?> hover:text-white transition-all" title="<?= $user['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                                        <i class="fa-solid <?= $user['is_active'] ? 'fa-user-slash' : 'fa-user-check'; ?>"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($user['role_name'] === 'ORGANIZER'): ?>
                                                <form action="<?= BASE_URL; ?>/actions/admin_actions.php" method="POST" class="inline">
                                                    <input type="hidden" name="action" value="toggle_organizer_acceptance">
                                                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center <?= $user['is_acceptable'] ? 'text-amber-400 hover:bg-amber-600' : 'text-indigo-400 hover:bg-indigo-600'; ?> hover:text-white transition-all" title="<?= $user['is_acceptable'] ? 'Revoke Organizer Access' : 'Approve Organizer'; ?>">
                                                        <i class="fa-solid <?= $user['is_acceptable'] ? 'fa-user-shield' : 'fa-user-plus'; ?>"></i>
                                                    </button>
                                                </form>
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
        // User Management Scripts
    </script>
</body>

</html>