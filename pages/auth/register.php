<?php
require_once "../../config/App.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind.config.js?v=1.2"></script>
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

        .role-card.active {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
        }
    </style>
</head>

<body class="bg-[#0f172a] text-slate-200 min-h-screen flex justify-center p-6 relative overflow-x-hidden">
    <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-2xl glass border border-slate-700/50 rounded-[2.5rem] p-10 shadow-2xl relative z-10 my-auto">
        <div class="text-center mb-8">
            <a href="../../index.php" class="text-3xl font-black inline-block mb-2">
                <span class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">BuyMatch</span>
            </a>
            <h2 class="text-2xl font-bold text-white mb-2">Join the Passion</h2>
            <p class="text-slate-400 text-sm">Choose your role and start the adventure.</p>
        </div>

        <form id="registerForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <label class="role-card border border-slate-700/50 p-4 rounded-3xl cursor-pointer hover:border-indigo-500 transition-all group relative overflow-hidden">
                    <input type="radio" name="role" value="buyer" checked class="hidden peer">
                    <div class="absolute inset-0 bg-indigo-500/0 peer-checked:bg-indigo-500/10 transition-all"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center peer-checked:bg-indigo-500 group-hover:scale-110 transition-all text-xl">
                            <i class="fa-solid fa-user-tag text-indigo-400 peer-checked:text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white uppercase tracking-wider text-xs">I am a</p>
                            <p class="text-lg font-black text-white">Buyer</p>
                        </div>
                    </div>
                </label>
                <label class="role-card border border-slate-700/50 p-4 rounded-3xl cursor-pointer hover:border-purple-500 transition-all group relative overflow-hidden">
                    <input type="radio" name="role" value="organizer" class="hidden peer">
                    <div class="absolute inset-0 bg-purple-500/0 peer-checked:bg-purple-500/10 transition-all"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-2xl flex items-center justify-center peer-checked:bg-purple-500 group-hover:scale-110 transition-all text-xl">
                            <i class="fa-solid fa-building-user text-purple-400 peer-checked:text-white"></i>
                        </div>
                        <div>
                            <p class="font-bold text-white uppercase tracking-wider text-xs">I am an</p>
                            <p class="text-lg font-black text-white">Organizer</p>
                        </div>
                    </div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">First Name</label>
                    <input type="text" name="firstname" required placeholder="John"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">Last Name</label>
                    <input type="text" name="lastname" required placeholder="Doe"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">Phone Number</label>
                    <input type="text" name="phone" placeholder="+212 600 000 000"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">Secure Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all placeholder:text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase ml-2">Profile Image</label>
                    <div class="relative group">
                        <input type="file" name="profile_image" accept="image/*"
                            class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl px-5 py-3.5 text-white focus:ring-2 focus:ring-indigo-500/50 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Organizer specific fields (Hidden by default) -->
            <div id="organizerFields" class="hidden space-y-6 pt-6 border-t border-slate-800/50 transition-all duration-500 overflow-hidden opacity-0 max-h-0">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-purple-400 uppercase ml-2">Company Name</label>
                        <input type="text" name="company_name" placeholder="Arena Events Co."
                            class="w-full bg-slate-900/50 border border-purple-900/20 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-purple-500/50 outline-none transition-all placeholder:text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-purple-400 uppercase ml-2">Company Logo</label>
                        <div class="relative group">
                            <input type="file" name="company_logo" accept="image/*"
                                class="w-full bg-slate-900/50 border border-purple-900/20 rounded-2xl px-5 py-3.5 text-white focus:ring-2 focus:ring-purple-500/50 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-purple-600 file:text-white hover:file:bg-purple-500 cursor-pointer">
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-purple-400 uppercase ml-2">Organizer Bio</label>
                    <textarea name="bio" rows="3" placeholder="Tell us about your events and experience..."
                        class="w-full bg-slate-900/50 border border-purple-900/20 rounded-2xl px-5 py-4 text-white focus:ring-2 focus:ring-purple-500/50 outline-none transition-all placeholder:text-slate-700 resize-none"></textarea>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-[0.98] tracking-widest text-sm flex items-center justify-center gap-3">
                <i class="fa-solid fa-rocket animate-pulse"></i>
                JOIN THE ARENA
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-400">
            Already registered?
            <a href="login.php" class="text-indigo-400 font-bold hover:underline">Sign in</a>
        </div>
    </div>

    <script src="../../assets/js/register.js?v=1.2"></script>
</body>

</html>