<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Naufal Adli</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: #e5e7eb; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        .glass-input { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s ease; }
        .glass-input:focus { background: rgba(255, 255, 255, 0.08); border-color: #3b82f6; outline: none; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-[128px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] -z-10"></div>

    <a href="{{ route('home') }}" class="absolute top-6 left-6 text-gray-400 hover:text-white transition flex items-center gap-2 group">
        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Home
    </a>

    <div class="w-full max-w-md p-8 mx-4 glass-card rounded-2xl">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-blue-900/50">N</div>
            <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
            <p class="text-gray-400 text-sm mt-2">Please enter your details to sign in.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 text-green-400 text-sm rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.perform') }}" method="POST" class="space-y-5">
            @csrf <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                           class="w-full pl-10 pr-4 py-3 rounded-xl glass-input text-sm placeholder-gray-600 @error('email') border-red-500 @enderror" required autofocus>
                </div>
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    <input type="password" name="password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 rounded-xl glass-input text-sm placeholder-gray-600" required>
                </div>
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-400 hover:text-gray-300 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-gray-800">
                    <span class="ml-2">Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-1">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
