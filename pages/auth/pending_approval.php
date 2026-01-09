<?php
require_once __DIR__ . '/../../config/App.php';

$currentUser = Auth::getCurrentUser();

if (!$currentUser || $currentUser->getRoleId() != 2) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

if ($currentUser->isAcceptable()) {
    header('Location: ' . BASE_URL . '/pages/organizer/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval | BuyMatch</title>
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

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-purple-600/10 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-md w-full relative">
        <div class="glass border border-slate-700/50 rounded-[2.5rem] p-10 text-center shadow-2xl">
            <div class="w-20 h-20 bg-amber-500/20 rounded-3xl flex items-center justify-center text-amber-500 mx-auto mb-8 text-3xl animate-pulse">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <h1 class="text-3xl font-black text-white mb-4">Account Pending</h1>
            <p class="text-slate-400 mb-8 leading-relaxed">
                Welcome, <span class="text-indigo-400 font-bold"><?php echo htmlspecialchars($currentUser->getFirstname()); ?></span>!
                Your organizer account is currently being reviewed by our administrators.
                You'll gain full access to the dashboard once approved.
            </p>

            <div class="space-y-4">
                <div class="p-4 bg-slate-800/50 rounded-2xl border border-slate-700/50 text-sm text-slate-400 italic">
                    <i class="fa-solid fa-circle-info mr-2"></i>
                    This process usually takes less than 24 hours.
                </div>

                <a href="<?= BASE_URL; ?>/actions/Auth/logout.action.php"
                    class="flex items-center justify-center gap-3 w-full py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl transition-all border border-slate-700">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Log Out
                </a>
            </div>
        </div>

        <p class="text-center mt-10 text-slate-500 text-sm">
            &copy; <?= date('Y'); ?> BuyMatch. All rights reserved.
        </p>
    </div>
</body>

</html>