<?php
require_once '../config/App.php';

Auth::requireLogin();
$userId = $_SESSION['user_id'];
$userRepo = new UserRepository();
$user = $userRepo->find($userId);


$isOrganizer = $user instanceof Organizer;
/** @var Organizer $user */ // Skip the IDE error
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | BuyMatch</title>
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
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200">

    <?php if ($isOrganizer): ?>
        <?php include '../includes/organizer_sidebar.php'; ?>
    <?php else: ?>
        <!-- Basic Nav for others -->
        <nav class="fixed top-0 w-full z-50 glass border-b border-slate-700/50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <a href="../index.php" class="text-2xl font-black text-white">BuyMatch</a>
                <div class="flex items-center gap-4">
                    <a href="../index.php" class="text-slate-400 hover:text-white transition">Browse Matches</a>
                    <span class="text-slate-600">|</span>
                    <a href="../actions/Auth/logout.action.php" class="text-red-400 hover:text-red-300 transition">Log Out</a>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <main class="<?php echo $isOrganizer ? 'lg:ml-64' : 'pt-20'; ?> min-h-screen p-8 flex justify-center">

        <div class="w-full max-w-2xl">
            <h1 class="text-3xl font-black text-white mb-8 border-l-4 border-indigo-500 pl-4">Edit Profile</h1>

            <form id="profileForm" class="glass border border-slate-700/50 rounded-3xl p-8 space-y-6" enctype="multipart/form-data">

                <!-- Profile Image -->
                <div class="flex items-center gap-6">
                    <div class="relative w-24 h-24 rounded-full overflow-hidden bg-slate-800 border-2 border-slate-600">
                        <?php if (!empty($user->getImgPath())): ?>
                            <img src="<?php echo BASE_URL . '/' . htmlspecialchars($user->getImgPath()); ?>" id="previewImg" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div id="previewFallback" class="w-full h-full flex items-center justify-center text-slate-500 text-3xl font-bold">
                                <?php echo substr($user->getFirstname(), 0, 1); ?>
                            </div>
                            <img id="previewImg" class="w-full h-full object-cover hidden">
                        <?php endif; ?>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-400 mb-2">Profile Picture</label>
                        <input type="file" name="img_path" id="imgPath" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-400 mb-1">First Name</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($user->getFirstname()); ?>" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-400 mb-1">Last Name</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($user->getLastname()); ?>" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-400 mb-1">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-400 mb-1">Phone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($user->getPhone()); ?>" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                </div>

                <?php if ($isOrganizer): ?>
                    <div class="border-t border-slate-700/50 pt-6">
                        <h2 class="text-xl font-bold text-white mb-4">Organizer Details</h2>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-400 mb-1">Company Name</label>
                            <input type="text" name="company_name" value="<?php echo htmlspecialchars($user->getCompanyName() ?? ''); ?>" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors" required>
                        </div>

                        <div class="flex items-center gap-6 mb-6">
                            <div class="relative w-16 h-16 rounded-xl overflow-hidden bg-slate-800 border-2 border-slate-600">
                                <?php if ($user->getLogo()): ?>
                                    <img src="<?php echo BASE_URL . '/' . htmlspecialchars($user->getLogo()); ?>" id="previewLogo" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div id="previewLogoFallback" class="w-full h-full flex items-center justify-center text-slate-500 text-xs text-center">No Logo</div>
                                    <img id="previewLogo" class="w-full h-full object-cover hidden">
                                <?php endif; ?>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-400 mb-2">Company Logo</label>
                                <input type="file" name="logo" id="logoInp" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-1">Bio</label>
                            <textarea name="bio" rows="4" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors"><?php echo htmlspecialchars($user->getBio() ?? ''); ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="border-t border-slate-700/50 pt-6">
                    <h2 class="text-xl font-bold text-white mb-4">Change Password</h2>
                    <p class="text-xs text-slate-500 mb-4">Leave blank to keep current password.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-1">New Password</label>
                            <input type="password" name="password" minlength="6" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-400 mb-1">Confirm Password</label>
                            <input type="password" name="confirm_password" minlength="6" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" id="submitBtn" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
                        <span>Save Changes</span>
                        <i class="fa-solid fa-check"></i>
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        // Image Previews
        const setupPreview = (input, imgId, fallbackId) => {
            input.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.getElementById(imgId);
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        if (fallbackId) document.getElementById(fallbackId).classList.add('hidden');
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        const imgInput = document.getElementById('imgPath');
        if (imgInput) setupPreview(imgInput, 'previewImg', 'previewFallback');

        const logoInput = document.getElementById('logoInp');
        if (logoInput) setupPreview(logoInput, 'previewLogo', 'previewLogoFallback');


        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
            btn.disabled = true;

            const formData = new FormData(this);

            try {
                const response = await fetch('../actions/profile/update_profile.action.php', {
                    method: 'POST',
                    body: formData
                });

                // Handle non-JSON responses gracefully
                const text = await response.text();
                let result;
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Server Error:', text);
                    alert('Server error occurred. See console.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    return;
                }

                if (result.success) {
                    alert('Profile updated successfully!');
                    location.reload();
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