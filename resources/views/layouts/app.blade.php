<!doctype html>
<html lang="en" class="scroll-smooth dark">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#050505">
    <title>@yield('title', 'Naufal Syahruradli | Cyber Security & Backend Dev')</title>
    <meta name="description" content="@yield('meta_description', 'Portfolio Naufal Syahruradli - Backend Developer & Cyber Security Enthusiast specialized in Laravel and Network Security.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Backend Developer, IoT, Cyber Security, Laravel, Penetration Testing, Naufal Syahruradli')">
    <meta name="author" content="Naufal Syahruradli">
    <meta name="robots" content="index, follow"><link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Naufal Syahruradli | Portfolio')">
    <meta property="og:description" content="@yield('meta_description', 'Portfolio Naufal Syahruradli - Backend Developer & Cyber Security Enthusiast.')">
    <meta property="og:image" content="@yield('og_image', asset('img/adli2.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Naufal Syahruradli | Portfolio')">
    <meta name="twitter:description" content="@yield('meta_description', 'Portfolio Naufal Syahruradli - Backend Developer & Cyber Security Enthusiast.')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/adli2.png'))">

    {{-- PWA & Icons --}}
    <link rel="icon" type="image/png" href="{{ asset('img/adli2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/adli2.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    {{-- Preload Critical Resources --}}
    <link rel="preload" href="{{ asset('css/aos.css') }}" as="style">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; transition: background-color 0.3s, color 0.3s; }

        /* Dark Mode (Default) */
        .dark body, html.dark body { background-color: #050505; color: #e5e7eb; }
        .dark ::-webkit-scrollbar { width: 8px; }
        .dark ::-webkit-scrollbar-track { background: #0a0a0a; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #3b82f6; }
        .dark .glass-nav { background: rgba(5, 5, 5, 0.7); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .dark .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }
        .dark .glass-input { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s; }
        .dark .glass-input:focus { background: rgba(255, 255, 255, 0.08); border-color: #3b82f6; outline: none; box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); }
        .dark .bg-dark-section { background-color: #0a0a0a; }
        .dark .bg-darker-section { background-color: #050505; }
        .dark .text-main { color: #e5e7eb; }
        .dark .text-muted-custom { color: #9ca3af; }
        .dark footer { background-color: #050505; border-color: rgba(255, 255, 255, 0.1); }

        /* Light Mode */
        html:not(.dark) body { background-color: #f8fafc; color: #1e293b; }
        html:not(.dark) ::-webkit-scrollbar { width: 8px; }
        html:not(.dark) ::-webkit-scrollbar-track { background: #e2e8f0; }
        html:not(.dark) ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        html:not(.dark) ::-webkit-scrollbar-thumb:hover { background: #3b82f6; }
        html:not(.dark) .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0, 0, 0, 0.1); }
        html:not(.dark) .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; }
        html:not(.dark) .glass-input { background: rgba(255, 255, 255, 0.9); border: 1px solid #d1d5db; color: #1e293b; transition: all 0.3s; }
        html:not(.dark) .glass-input:focus { background: white; border-color: #3b82f6; outline: none; box-shadow: 0 0 15px rgba(59, 130, 246, 0.2); }
        html:not(.dark) .bg-dark-section, html:not(.dark) .bg-\[\#0a0a0a\] { background-color: #f1f5f9 !important; }
        html:not(.dark) .bg-darker-section, html:not(.dark) .bg-\[\#050505\] { background-color: #f8fafc !important; }
        html:not(.dark) .text-white { color: #1e293b !important; }
        html:not(.dark) .text-gray-300, html:not(.dark) .text-gray-400 { color: #64748b !important; }
        html:not(.dark) .text-gray-500 { color: #94a3b8 !important; }
        html:not(.dark) .border-white\/10, html:not(.dark) .border-white\/5 { border-color: rgba(0, 0, 0, 0.1) !important; }
        html:not(.dark) footer { background-color: #f8fafc !important; border-color: rgba(0, 0, 0, 0.1) !important; }
        html:not(.dark) #preloader { background-color: #f8fafc !important; }
        html:not(.dark) .bg-blue-600\/20, html:not(.dark) .bg-purple-600\/20 { opacity: 0.3; }
        html:not(.dark) select.bg-\[\#050505\] { background-color: #ffffff !important; color: #1e293b !important; border: 1px solid #d1d5db !important; }
        html:not(.dark) .bg-gradient-to-t.from-\[\#050505\] { background: linear-gradient(to top, rgba(248, 250, 252, 0.9), transparent) !important; }
        html:not(.dark) .bg-black\/50 { background-color: rgba(255, 255, 255, 0.9) !important; }
        html:not(.dark) .border-gray-800 { border-color: #e2e8f0 !important; }
        html:not(.dark) .border-gray-700 { border-color: #cbd5e1 !important; }
        html:not(.dark) .bg-\[\#111\] { background-color: #ffffff !important; }
        html:not(.dark) .from-\[\#050505\] { --tw-gradient-from: #f8fafc !important; }
        html:not(.dark) .via-\[\#050505\]\/50 { --tw-gradient-via: rgba(248, 250, 252, 0.5) !important; }
        html:not(.dark) .text-blue-400 { color: #2563eb !important; }
        html:not(.dark) .text-blue-500 { color: #3b82f6 !important; }
        html:not(.dark) .hover\:text-blue-400:hover { color: #2563eb !important; }
        html:not(.dark) .bg-white\/5, html:not(.dark) .bg-white\/10 { background-color: rgba(0, 0, 0, 0.05) !important; }
        html:not(.dark) .hover\:bg-white\/5:hover, html:not(.dark) .hover\:bg-white\/10:hover { background-color: rgba(0, 0, 0, 0.08) !important; }
        html:not(.dark) .bg-black\/60 { background-color: rgba(255, 255, 255, 0.8) !important; }
        html:not(.dark) .bg-black\/90 { background-color: rgba(255, 255, 255, 0.95) !important; }
        html:not(.dark) .text-white\/70, html:not(.dark) .text-white\/80 { color: #475569 !important; }
        html:not(.dark) input.text-white, html:not(.dark) textarea.text-white { color: #1e293b !important; }
        html:not(.dark) input::placeholder, html:not(.dark) textarea::placeholder { color: #94a3b8 !important; }
        html:not(.dark) .grayscale { filter: none !important; }

        /* Common Styles */
        .loader { width: 50px; height: 50px; border-radius: 50%; border: 3px solid transparent; border-top-color: #3b82f6; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .timeline-line::before { content: ''; position: absolute; top: 0; bottom: 0; left: 1.5rem; width: 2px; background: linear-gradient(to bottom, #3b82f6, transparent); z-index: 0; }
        @media (min-width: 1024px) { .timeline-line::before { left: 50%; transform: translateX(-50%); } }

        /* Theme Toggle Switch */
        .theme-switch {
            font-size: 17px;
            position: relative;
            display: inline-block;
            width: 64px;
            height: 34px;
        }
        .theme-switch .theme-input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .theme-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #73C0FC;
            transition: .4s;
            border-radius: 30px;
        }
        .theme-slider:before {
            position: absolute;
            content: "";
            height: 30px;
            width: 30px;
            border-radius: 20px;
            left: 2px;
            bottom: 2px;
            z-index: 2;
            background-color: #e8e8e8;
            transition: .4s;
        }
        .theme-switch .sun svg {
            position: absolute;
            top: 6px;
            left: 36px;
            z-index: 1;
            width: 24px;
            height: 24px;
        }
        .theme-switch .moon svg {
            fill: #73C0FC;
            position: absolute;
            top: 5px;
            left: 5px;
            z-index: 1;
            width: 24px;
            height: 24px;
        }
        .theme-switch .sun svg {
            animation: rotate 15s linear infinite;
        }
        @keyframes rotate {
            0% { transform: rotate(0); }
            100% { transform: rotate(360deg); }
        }
        .theme-switch .moon svg {
            animation: tilt 5s linear infinite;
        }
        @keyframes tilt {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }
        .theme-input:checked + .theme-slider {
            background-color: #183153;
        }
        .theme-input:focus + .theme-slider {
            box-shadow: 0 0 1px #183153;
        }
        .theme-input:checked + .theme-slider:before {
            transform: translateX(30px);
        }

        /* Custom Cursor */
        .cursor-dot {
            width: 8px;
            height: 8px;
            background-color: #3b82f6;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease;
            transform: translate(-50%, -50%);
        }
        .cursor-outline {
            width: 40px;
            height: 40px;
            border: 2px solid rgba(59, 130, 246, 0.5);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transition: all 0.15s ease-out;
            transform: translate(-50%, -50%);
        }
        .cursor-outline.hover {
            width: 60px;
            height: 60px;
            border-color: rgba(59, 130, 246, 0.8);
            background: rgba(59, 130, 246, 0.1);
        }
        .cursor-outline.clicking {
            transform: translate(-50%, -50%) scale(0.8);
        }
        @media (max-width: 768px) {
            .cursor-dot, .cursor-outline { display: none; }
        }

        /* Scroll Progress Bar */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            z-index: 9999;
            transition: width 0.1s ease-out;
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #1a1a2e 25%, #252542 50%, #1a1a2e 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 8px;
        }
        html:not(.dark) .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-img {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        img.loaded + .skeleton-img { display: none; }

        /* Animated Counter */
        .counter-value {
            display: inline-block;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        }

        /* Testimonial Slider */
        .testimonial-slider {
            position: relative;
            overflow: hidden;
        }
        .testimonial-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .testimonial-card {
            min-width: 100%;
            padding: 0 1rem;
        }
        @media (min-width: 768px) {
            .testimonial-card { min-width: 50%; }
        }
        @media (min-width: 1024px) {
            .testimonial-card { min-width: 33.333%; }
        }
        .testimonial-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 2rem;
        }
        .testimonial-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s;
        }
        .testimonial-dot.active {
            background: #3b82f6;
            transform: scale(1.2);
        }
        html:not(.dark) .testimonial-dot {
            background: rgba(0, 0, 0, 0.2);
        }
    </style>

    <script>
        // Check theme on page load (before render to prevent flash)
        (function() {
            const isDark = localStorage.getItem('theme') === 'dark' ||
                          (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body>
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Custom Cursor -->
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-outline" id="cursorOutline"></div>

    <!-- Back to Top Button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <div id="preloader" class="fixed inset-0 bg-[#050505] flex items-center justify-center z-[9999]">
        <div class="loader"></div>
    </div>

    <nav class="fixed w-full top-0 z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg group-hover:rotate-12 transition-transform">N</div>
                <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-tight">Naufal<span class="text-blue-500">Adli</span></span>
            </a>

            <button id="menu-toggle" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-400 rounded-lg md:hidden hover:bg-white/10 focus:outline-none">
                <span class="sr-only">Open main menu</span>
                <i class="fa-solid fa-bars text-xl"></i>
            </button>

            <div class="hidden w-full md:block md:w-auto transition-all duration-300" id="mobile-menu">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-800 rounded-lg bg-black/50 md:bg-transparent md:flex-row md:space-x-8 md:mt-0 md:border-0">

                    {{-- Home (Active State) --}}
                    <li>
                        <a href="{{ route('home') }}#home"
                        class="block py-2 px-3 text-white hover:text-blue-400 transition-colors">
                        Home
                        </a>
                    </li>

                    {{-- Menu Items --}}
                    <li>
                        <a href="{{ route('home') }}#about"
                        class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors">
                        About
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#tech"
                        class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors">
                        Tech
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#experience"
                        class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors">
                        Exp
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#project"
                        class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors">
                        Project
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#contact"
                        class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors">
                        Contact
                        </a>
                    </li>

                    {{-- Dashboard (Auth Only) --}}
                    @auth
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                            class="block py-2 px-3 text-gray-300 dark:text-gray-300 hover:text-blue-400 transition-colors border-l border-gray-700 pl-6 ml-2">
                            Dashboard
                            </a>
                        </li>
                    @endauth

                    {{-- Theme Toggle --}}
                    <li class="flex items-center md:ml-4 md:pl-4 md:border-l md:border-gray-700">
                        <label class="theme-switch">
                            <span class="sun"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="#ffd43b"><circle r="5" cy="12" cx="12"></circle><path d="m21 13h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm-17 0h-1a1 1 0 0 1 0-2h1a1 1 0 0 1 0 2zm13.66-5.66a1 1 0 0 1 -.66-.29 1 1 0 0 1 0-1.41l.71-.71a1 1 0 1 1 1.41 1.41l-.71.71a1 1 0 0 1 -.75.29zm-12.02 12.02a1 1 0 0 1 -.71-.29 1 1 0 0 1 0-1.41l.71-.66a1 1 0 0 1 1.41 1.41l-.71.71a1 1 0 0 1 -.7.24zm6.36-14.36a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm0 17a1 1 0 0 1 -1-1v-1a1 1 0 0 1 2 0v1a1 1 0 0 1 -1 1zm-5.66-14.66a1 1 0 0 1 -.7-.29l-.71-.71a1 1 0 0 1 1.41-1.41l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.29zm12.02 12.02a1 1 0 0 1 -.7-.29l-.66-.71a1 1 0 0 1 1.36-1.36l.71.71a1 1 0 0 1 0 1.41 1 1 0 0 1 -.71.24z"></path></g></svg></span>
                            <span class="moon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="m223.5 32c-123.5 0-223.5 100.3-223.5 224s100 224 223.5 224c60.6 0 115.5-24.2 155.8-63.4 5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6-96.9 0-175.5-78.8-175.5-176 0-65.8 36-123.1 89.3-153.3 6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path></svg></span>
                            <input type="checkbox" class="theme-input" id="theme-toggle">
                            <span class="theme-slider"></span>
                        </label>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-sm px-4" id="alert">
        @if (session('success'))
            <div id="alert-box" class="bg-green-500/10 border border-green-500/30 text-green-400 text-center p-3 font-semibold rounded-xl backdrop-blur-md shadow-lg" data-aos="fade-down">
                <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
         @if (session('error'))
            <div id="alert-box" class="bg-red-500/10 border border-red-500/30 text-red-400 text-center p-3 font-semibold rounded-xl backdrop-blur-md shadow-lg" data-aos="fade-down">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="bg-[#050505] border-t border-white/10 pt-16 pb-8 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[#050505] blur-[120px] pointer-events-none"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                <div class="lg:col-span-2 space-y-4" data-aos="fade-right">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group w-fit">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg group-hover:rotate-12 transition-transform">N</div>
                        <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-tight">Naufal<span class="text-blue-500">Adli</span></span>
                    </a>
                    @php
                        $footerProfile = \App\Models\Home::first();
                    @endphp
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs text-justify">
                        {{ $footerProfile->deskripsi }}
                    </p>
                    <div class="pt-4">
                        @if(optional($footerProfile)->mail)
                        <a href="mailto:{{ $footerProfile->mail }}" class="text-sm text-white border border-white/20 px-4 py-2 rounded-lg hover:bg-blue-600 hover:border-blue-600 transition-all">
                            <i class="fas fa-envelope mr-2"></i> Hire Me
                        </a>
                        @endif
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-white font-bold mb-6">Quick Links</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}#home" class="hover:text-blue-500 hover:pl-2 transition-all duration-300 block">Home</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-blue-500 hover:pl-2 transition-all duration-300 block">About Me</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-blue-500 hover:pl-2 transition-all duration-300 block">Projects</a></li>
                        <li><a href="{{ route('home') }}#contact" class="hover:text-blue-500 hover:pl-2 transition-all duration-300 block">Contact</a></li>
                    </ul>
                </div>

                <div data-aos="fade-left" data-aos-delay="200">
                    <h3 class="text-white font-bold mb-6">Connect</h3>


                    <div class="flex gap-4">
                        @if(optional($footerProfile)->github)
                            <a href="{{ $footerProfile->github }}" target="_blank" class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-gray-400 hover:text-white hover:border-white transition-all duration-300 group">
                                <i class="fab fa-github text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                        @endif

                        @if(optional($footerProfile)->linkedin)
                            <a href="{{ $footerProfile->linkedin }}" target="_blank" class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-gray-400 hover:text-blue-600 hover:border-blue-600 transition-all duration-300 group">
                                <i class="fab fa-linkedin-in text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                        @endif

                        @if(optional($footerProfile)->instagram)
                            <a href="{{ $footerProfile->instagram }}" target="_blank" class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-gray-400 hover:text-pink-600 hover:border-pink-600 transition-all duration-300 group">
                                <i class="fab fa-instagram text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                        @endif
                    </div>

                    <p class="text-gray-500 text-xs mt-4">
                        Surabaya, Indonesia <br>
                        Server Time: {{ date("H:i") }} WIB
                    </p>
                </div>
            </div>

            <hr class="border-white/5 mb-8">

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>
                    © {{ date("Y") }} <span class="text-white font-semibold">{{ optional($footerProfile)->nama ?? 'Naufal Syahruradli' }}</span>. All Rights Reserved.
                </p>
                <div class="flex items-center gap-1">
                    <span>Crafted with</span>
                    <i class="fas fa-heart text-red-500 animate-pulse mx-1"></i>
                    <span>& Coffee</span>
                </div>

                <a href="#" class="hidden md:flex items-center gap-2 text-gray-400 hover:text-blue-500 transition-colors">
                    Back to Top <i class="fas fa-arrow-up"></i>
                </a>
            </div>
        </div>
    </footer>
    <div id="imageModal" class="fixed inset-0 z-[9999] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center opacity-0 transition-opacity duration-300">
        <button onclick="closeModal()" class="absolute top-6 right-6 text-white/70 hover:text-white text-4xl focus:outline-none z-50">
            &times;
        </button>

        <div class="relative max-w-7xl max-h-[90vh] p-4">
            <img loading="lazy" id="modalImage" src="" alt="Full Preview" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain transform scale-95 transition-transform duration-300">
            <p id="modalCaption" class="text-center text-white/80 mt-4 text-sm font-light"></p>
        </div>
    </div>

    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');

        function openModal(src, caption = '') {
            modal.classList.remove('hidden');
            // Sedikit delay agar animasi opacity jalan
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            }, 10);

            modalImg.src = src;
            modalCaption.innerText = caption;
            document.body.style.overflow = 'hidden'; // Matikan scroll body
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                modalImg.src = ''; // Reset source
            }, 300); // Sesuaikan dengan duration-300
            document.body.style.overflow = 'auto'; // Hidupkan scroll body
        }

        // Tutup jika klik di luar gambar (background gelap)
        modal.addEventListener('click', function(e) {
            if (e.target === modal || e.target.closest('.container')) {
                closeModal();
            }
        });

        // Tutup pakai tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeModal();
        });
    </script>

    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/vanilla-tilt.min.js') }}"></script>
    <script src="https://unpkg.com/typeit@8.7.1/dist/index.umd.js"></script>

    <script>
        // Init Global Plugins
        AOS.init({ once: true, duration: 800, offset: 50 });

        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15, speed: 400, glare: true, "max-glare": 0.1
        });

        // Preloader & Alert
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if(preloader) {
                preloader.style.opacity = '0';
                setTimeout(() => preloader.style.display = 'none', 500);
            }

            const alertBox = document.getElementById("alert-box");
            if(alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-20px)';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }
        });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById("menu-toggle");
        const menu = document.getElementById("mobile-menu");
        if(menuToggle && menu){
            menuToggle.addEventListener("click", () => { menu.classList.toggle("hidden"); });
            document.querySelectorAll('#mobile-menu a').forEach(link => { link.addEventListener('click', () => menu.classList.add('hidden')); });
        }

        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            // Set initial checkbox state based on current theme
            themeToggle.checked = document.documentElement.classList.contains('dark');

            themeToggle.addEventListener('change', () => {
                const html = document.documentElement;

                if (themeToggle.checked) {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            });
        }

        // Custom Cursor
        const cursorDot = document.getElementById('cursorDot');
        const cursorOutline = document.getElementById('cursorOutline');

        if (cursorDot && cursorOutline && window.innerWidth > 768) {
            let mouseX = 0, mouseY = 0;
            let outlineX = 0, outlineY = 0;

            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursorDot.style.left = mouseX + 'px';
                cursorDot.style.top = mouseY + 'px';
            });

            // Smooth follow for outline
            function animateOutline() {
                outlineX += (mouseX - outlineX) * 0.15;
                outlineY += (mouseY - outlineY) * 0.15;
                cursorOutline.style.left = outlineX + 'px';
                cursorOutline.style.top = outlineY + 'px';
                requestAnimationFrame(animateOutline);
            }
            animateOutline();

            // Hover effect on interactive elements
            const hoverElements = document.querySelectorAll('a, button, input, textarea, [data-cursor-hover]');
            hoverElements.forEach(el => {
                el.addEventListener('mouseenter', () => cursorOutline.classList.add('hover'));
                el.addEventListener('mouseleave', () => cursorOutline.classList.remove('hover'));
            });

            // Click effect
            document.addEventListener('mousedown', () => cursorOutline.classList.add('clicking'));
            document.addEventListener('mouseup', () => cursorOutline.classList.remove('clicking'));
        }

        // Scroll Progress Bar
        const scrollProgress = document.getElementById('scrollProgress');
        if (scrollProgress) {
            window.addEventListener('scroll', () => {
                const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const progress = (scrollTop / scrollHeight) * 100;
                scrollProgress.style.width = progress + '%';
            });
        }

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 500) {
                    backToTop.classList.add('visible');
                } else {
                    backToTop.classList.remove('visible');
                }
            });

            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Animated Counter
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start);
                }
            }, 16);
        }

        // Intersection Observer for counters
        const counterElements = document.querySelectorAll('[data-counter]');
        if (counterElements.length > 0) {
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                        const target = parseInt(entry.target.dataset.counter);
                        animateCounter(entry.target, target);
                        entry.target.classList.add('counted');
                    }
                });
            }, { threshold: 0.5 });

            counterElements.forEach(el => counterObserver.observe(el));
        }

        // Skeleton Loading for Images
        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            if (img.complete) {
                img.classList.add('loaded');
            } else {
                img.addEventListener('load', () => img.classList.add('loaded'));
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
