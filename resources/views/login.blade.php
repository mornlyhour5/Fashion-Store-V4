<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Noir & Or</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Custom Gold Gradients and Glows */
        .gold-gradient {
            background: linear-gradient(135deg, #BF953F 0%, #FCF6BA 25%, #B38728 50%, #FBF5B7 75%, #AA771C 100%);
        }
        .gold-border-focus:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
        }
        .hidden-form {
            display: none;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-zinc-950 via-black to-zinc-900 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="relative w-full max-w-md bg-zinc-900/80 backdrop-blur-md border border-zinc-800 p-8 rounded-2xl shadow-2xl shadow-black/50">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-zinc-950 border border-amber-500/30 shadow-lg shadow-amber-500/10 mb-3">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 12h12l3-12-4 4-4-6-4 6-4-4z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-widest text-transparent bg-clip-text gold-gradient uppercase">The Onyx Club</h1>
            <p class="text-zinc-500 text-xs mt-1 tracking-wider uppercase">Premium Access Portal</p>
        </div>

        <div id="login-section">
            <h2 class="text-xl font-semibold text-zinc-200 mb-6 tracking-wide">Sign In</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required autocomplete="email" class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-3 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="name@example.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-zinc-500 hover:text-amber-400 transition">Forgot?</a>
                    </div>
                    <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-3 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded bg-zinc-950 border-zinc-800 text-amber-500 focus:ring-amber-500/50 accent-amber-500">
                    <label for="remember" class="ml-2 text-xs text-zinc-400 select-none">Keep me signed in</label>
                </div>

                <button type="submit" class="w-full gold-gradient text-zinc-950 font-bold text-sm uppercase tracking-widest py-3.5 rounded-lg shadow-lg shadow-amber-500/10 hover:opacity-90 active:scale-[0.99] transition duration-150 mt-2 cursor-pointer">
                    Authorize Access
                </button>
            </form>

            <div class="text-center mt-8 text-sm text-zinc-500">
                Don't have an account?
                <button onclick="toggleAuth()" class="text-amber-400 hover:underline font-medium focus:outline-none ml-1 cursor-pointer">Register</button>
            </div>
        </div>

        <div id="register-section" class="hidden-form">
            <h2 class="text-xl font-semibold text-zinc-200 mb-6 tracking-wide">Create Account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider mb-2">Full Name</label>
                    <input type="text" name="name" required class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="John Doe">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="john@example.com">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" required class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="••••••••">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-amber-400/80 uppercase tracking-wider mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-zinc-950 border border-zinc-800 text-zinc-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none gold-border-focus transition duration-200" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full gold-gradient text-zinc-950 font-bold text-sm uppercase tracking-widest py-3.5 rounded-lg shadow-lg shadow-amber-500/10 hover:opacity-90 active:scale-[0.99] transition duration-150 mt-4 cursor-pointer">
                    Register Membership
                </button>
            </form>

            <div class="text-center mt-6 text-sm text-zinc-500">
                Already a member?
                <button onclick="toggleAuth()" class="text-amber-400 hover:underline font-medium focus:outline-none ml-1 cursor-pointer">Sign In</button>
            </div>
        </div>

    </div>

    <script>
        function toggleAuth() {
            const loginSec = document.getElementById('login-section');
            const registerSec = document.getElementById('register-section');

            loginSec.classList.toggle('hidden-form');
            registerSec.classList.toggle('hidden-form');
        }
    </script>
</body>
</html>
