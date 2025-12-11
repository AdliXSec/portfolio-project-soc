<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Authentication') | {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('img/adli2.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script untuk mencegah Flash of Wrong Theme (FOUC) --}}
    <script>
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

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }

        /* --- THEME VARIABLES --- */
        :root {
            /* Light Mode Defaults */
            --bg-color: #f8fafc; /* Slate 50 */
            --text-main: #1e293b; /* Slate 800 */
            --text-muted: #64748b; /* Slate 500 */

            /* Glass Light */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(0, 0, 0, 0.1);
            --glass-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);

            /* Input Light */
            --input-bg: rgba(255, 255, 255, 0.9);
            --input-border: #d1d5db;
            --input-text: #1e293b;

            --blob-opacity: 0.4; /* Blobs lebih tipis di light mode */
        }

        /* Dark Mode Overrides */
        html.dark {
            --bg-color: #050505;
            --text-main: #e5e7eb;
            --text-muted: #9ca3af;

            /* Glass Dark */
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.05);
            --glass-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);

            /* Input Dark */
            --input-bg: rgba(255, 255, 255, 0.03);
            --input-border: rgba(255, 255, 255, 0.1);
            --input-text: #ffffff;

            --blob-opacity: 1;
        }

        /* --- GLOBAL STYLES --- */
        body {
            background-color: var(--bg-color);
            color: var(--text-main);
        }

        .text-muted-custom { color: var(--text-muted); }

        /* Glass Card Component */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            transition: all 0.3s ease;
        }

        /* Glass Input Component */
        .glass-input, .otp-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            transition: all 0.3s ease;
        }
        .glass-input::placeholder { color: var(--text-muted); }
        .glass-input:focus, .otp-input:focus {
            background: rgba(59, 130, 246, 0.1); /* Blue tint on focus */
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        /* Blobs Opacity Handling */
        .bg-blob { opacity: var(--blob-opacity); transition: opacity 0.5s ease; }

        /* Custom Cursor */
        .cursor-dot {
            width: 8px; height: 8px; background-color: #3b82f6;
            border-radius: 50%; position: fixed; pointer-events: none; z-index: 9999;
            transform: translate(-50%, -50%); transition: transform 0.1s ease;
        }
        .cursor-outline {
            width: 40px; height: 40px; border: 2px solid rgba(59, 130, 246, 0.5);
            border-radius: 50%; position: fixed; pointer-events: none; z-index: 9998;
            transform: translate(-50%, -50%); transition: all 0.15s ease-out;
        }
        .cursor-outline.hover { width: 60px; height: 60px; background: rgba(59, 130, 246, 0.1); }
        .cursor-outline.clicking { transform: translate(-50%, -50%) scale(0.8); }
        @media (max-width: 768px) { .cursor-dot, .cursor-outline { display: none; } }

        /* Theme Toggle Button (Optional Style) */
        .theme-toggle-btn {
            position: absolute; top: 1.5rem; right: 1.5rem;
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: var(--glass-bg); border: 1px solid var(--glass-border);
            color: var(--text-main); cursor: pointer; z-index: 50;
            transition: all 0.3s;
        }
        .theme-toggle-btn:hover { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    </style>
    @stack('styles')
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden selection:bg-blue-500 selection:text-white">

    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-outline" id="cursorOutline"></div>

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-[128px] -z-10 pointer-events-none bg-blob"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] -z-10 pointer-events-none bg-blob"></div>

    @yield('content')

    <script>
        // --- 1. Custom Cursor Logic ---
        const cursorDot = document.getElementById('cursorDot');
        const cursorOutline = document.getElementById('cursorOutline');

        if (cursorDot && cursorOutline && window.matchMedia("(pointer: fine)").matches) {
            let mouseX = 0, mouseY = 0, outlineX = 0, outlineY = 0;

            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
                cursorDot.style.left = mouseX + 'px';
                cursorDot.style.top = mouseY + 'px';
            });

            function animateOutline() {
                outlineX += (mouseX - outlineX) * 0.15;
                outlineY += (mouseY - outlineY) * 0.15;
                cursorOutline.style.left = outlineX + 'px';
                cursorOutline.style.top = outlineY + 'px';
                requestAnimationFrame(animateOutline);
            }
            animateOutline();

            document.querySelectorAll('a, button, input').forEach(el => {
                el.addEventListener('mouseenter', () => cursorOutline.classList.add('hover'));
                el.addEventListener('mouseleave', () => cursorOutline.classList.remove('hover'));
            });
            document.addEventListener('mousedown', () => cursorOutline.classList.add('clicking'));
            document.addEventListener('mouseup', () => cursorOutline.classList.remove('clicking'));
        }

        // --- 2. Theme Toggle Logic ---
        const themeBtn = document.getElementById('theme-toggle');
        const html = document.documentElement;

        if(themeBtn){
            themeBtn.addEventListener('click', () => {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
