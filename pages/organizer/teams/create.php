<?php
require_once '../../../includes/guards/role.guard.php';
requireRole(2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Team | BuyMatch</title>
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

    <main class="lg:ml-64 min-h-screen p-8 relative flex flex-col justify-center">
        <div class="absolute top-[10%] right-[10%] w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-2xl mx-auto w-full">
            <h1 class="text-3xl font-black text-white mb-8">Create New Team</h1>

            <div class="glass border border-slate-700/50 rounded-[2.5rem] p-10 shadow-2xl">
                <form id="createTeamForm" class="space-y-8" enctype="multipart/form-data">

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">Team Name</label>
                        <input type="text" name="name" required placeholder="Enter team name"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-500 uppercase ml-2">Team Logo</label>
                        <div class="relative group cursor-pointer">
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden">
                            <label for="logoInput" class="flex flex-col items-center justify-center w-full h-48 bg-slate-900/50 border-2 border-dashed border-slate-700/50 rounded-2xl group-hover:border-indigo-500/50 transition-all cursor-pointer overflow-hidden">
                                <div id="previewContainer" class="flex flex-col items-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-600 mb-4 group-hover:text-indigo-400 transition-colors"></i>
                                    <span class="text-sm text-slate-500 group-hover:text-slate-300">Click to upload logo</span>
                                    <span class="text-[10px] text-slate-600 mt-2">JPG, PNG, WebP allowed</span>
                                </div>
                                <img id="logoPreview" class="hidden w-full h-full object-contain p-4">
                            </label>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-sm flex items-center justify-center gap-3">
                            <i class="fa-solid fa-plus"></i>
                            CREATE TEAM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const logoInput = document.getElementById('logoInput');
        const logoPreview = document.getElementById('logoPreview');
        const previewContainer = document.getElementById('previewContainer');

        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.src = e.target.result;
                    logoPreview.classList.remove('hidden');
                    previewContainer.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('createTeamForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> CREATING...';
            btn.disabled = true;

            try {
                const response = await fetch('../../../actions/teams/create.action.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    alert(result.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred. Check console.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>