<?php
require_once '../../../includes/guards/role.guard.php';
requireRole(2, 3); // Organizer and Admin

$currentUser = Auth::getCurrentUser();
$sidebar = ($currentUser->getRoleId() == 3) ? '../../../includes/admin_sidebar.php' : '../../../includes/organizer_sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Venue | BuyMatch</title>
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

    <?php include $sidebar; ?>

    <main class="lg:ml-64 min-h-screen p-8 relative flex flex-col justify-center">
        <!-- Background Elements -->
        <div class="absolute top-[10%] right-[10%] w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-xl mx-auto w-full">
            <h1 class="text-3xl font-black text-white mb-8">Add New Venue</h1>

            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-10 shadow-2xl">
                <form id="createVenueForm" class="space-y-6">

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">Venue Name</label>
                        <input type="text" name="name" required placeholder="e.g. Santiago Bernabéu"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">City</label>
                        <input type="text" name="city" required placeholder="e.g. Madrid"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">Address</label>
                        <input type="text" name="address" required placeholder="e.g. Av. de Concha Espina, 1"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">Capacity</label>
                        <input type="number" name="capacity" required placeholder="e.g. 81044" min="1"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-sm flex items-center justify-center gap-3">
                            <i class="fa-solid fa-plus"></i>
                            ADD VENUE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('createVenueForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ADDING...';
            btn.disabled = true;

            try {
                const response = await fetch('../../../actions/venues/create.action.php', {
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