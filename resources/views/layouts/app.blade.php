<!doctype html>
<html lang="en" class="scroll-smooth">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'Naufal Syahruradli | Portfolio')</title>
    <meta name="description" content="@yield('meta_description', 'Portfolio Naufal Syahruradli')">
    <meta name="keywords" content="@yield('meta_keywords', 'Backend Developer, IoT, Cyber Security')">
    <meta name="author" content="Naufal Syahruradli">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:image" content="{{ asset('img/home/adli2.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/home/adli2.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: #e5e7eb; overflow-x: hidden; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3b82f6; }
        .glass-nav { background: rgba(5, 5, 5, 0.7); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }
        .glass-input { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.1); color: white; transition: all 0.3s; }
        .glass-input:focus { background: rgba(255, 255, 255, 0.08); border-color: #3b82f6; outline: none; box-shadow: 0 0 15px rgba(59, 130, 246, 0.3); }
        .loader { width: 50px; height: 50px; border-radius: 50%; border: 3px solid transparent; border-top-color: #3b82f6; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .timeline-line::before { content: ''; position: absolute; top: 0; bottom: 0; left: 1.5rem; width: 2px; background: linear-gradient(to bottom, #3b82f6, transparent); z-index: 0; }
        @media (min-width: 1024px) { .timeline-line::before { left: 50%; transform: translateX(-50%); } }
    </style>
</head>

<body>

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
                            class="block py-2 px-3 text-gray-300 hover:text-blue-400 transition-colors border-l border-gray-700 pl-6 ml-2">
                            Dashboard
                            </a>
                        </li>
                    @endauth

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
    </script>

    @stack('scripts')
</body>
</html>
