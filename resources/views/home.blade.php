{{--
    Tailwind Safelist Hack:
    border-l-blue-500 border-l-purple-500 border-l-green-500 border-l-red-500 border-l-yellow-500
--}}
@extends('layouts.app')

@section('title', 'Naufal Syahruradli | Backend Developer & Cyber Security')
@section('meta_description', 'Portfolio of Naufal Syahruradli - Backend Developer & Cyber Security Enthusiast.')
@section('meta_keywords', 'Naufal Syahruradli, Backend Developer, Cyber Security, Laravel, PHP, Portfolio')

@section('content')
    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px]"></div>

        <div class="container mx-auto p-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">

                <div class="order-2 md:order-1 space-y-6 text-center md:text-left" data-aos="fade-right" data-aos-duration="1000">
                    <div class="inline-block px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm font-semibold mb-2">
                        👋 Welcome to my portfolio
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight text-white">
                        Hi, I'm <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">{{ optional($profile)->nama ?? 'Naufal Syahruradli' }}</span>
                    </h1>

                    <div class="text-xl md:text-2xl text-gray-400 font-light h-10">
                        I am a <span id="role" class="font-semibold text-white"></span>
                    </div>

                    <p class="text-gray-400 max-w-lg mx-auto md:mx-0 leading-relaxed">
                        {{ optional($profile)->deskripsi ?? 'Transforming complex problems into elegant, secure, and scalable digital solutions. Let\'s build something amazing together.' }}
                    </p>

                    <div class="flex flex-wrap gap-4 justify-center md:justify-start pt-4">
                        <a href="#project" class="px-8 py-3 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-all shadow-[0_0_20px_rgba(37,99,235,0.3)] hover:shadow-[0_0_30px_rgba(37,99,235,0.5)]">
                            View Work
                        </a>
                        <a href="#contact" class="px-8 py-3 rounded-full border border-gray-600 hover:border-white text-gray-300 hover:text-white transition-all hover:bg-white/5">
                            Contact Me
                        </a>
                    </div>

                    <div class="flex gap-6 justify-center md:justify-start pt-6">
                        @if(optional($profile)->github)
                            <a href="{{ $profile->github }}" target="_blank" class="text-gray-400 hover:text-white hover:scale-110 transition-transform">
                                <i class="fa-brands fa-github text-2xl"></i>
                            </a>
                        @endif

                        @if(optional($profile)->linkedin)
                            <a href="{{ $profile->linkedin }}" target="_blank" class="text-gray-400 hover:text-blue-400 hover:scale-110 transition-transform">
                                <i class="fa-brands fa-linkedin text-2xl"></i>
                            </a>
                        @endif

                        @if(optional($profile)->instagram)
                            <a href="{{ $profile->instagram }}" target="_blank" class="text-gray-400 hover:text-pink-500 hover:scale-110 transition-transform">
                                <i class="fa-brands fa-instagram text-2xl"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="order-1 md:order-2 flex justify-center relative" data-aos="fade-left" data-aos-duration="1200">
                    <div class="relative w-64 h-64 md:w-80 md:h-80 lg:w-96 lg:h-96 group">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-purple-600 rounded-full blur-2xl opacity-40 group-hover:opacity-60 transition-opacity duration-500"></div>
                        <img  loading="lazy" src="{{ $profile && $profile->foto ? asset('storage/home/'.$profile->foto) : asset('img/adli2.png') }}"
                            alt="{{ optional($profile)->nama ?? 'Profile' }}"
                            class="relative w-full h-full object-cover rounded-full border-2 border-white/10 shadow-2xl z-10 grayscale group-hover:grayscale-0 transition-all duration-500 transform group-hover:scale-[1.02]">
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-10 z-50 animate-bounce hidden md:block">
            <a href="#about" class="text-gray-500 hover:text-white transition-colors cursor-pointer">
                <i class="fa-solid fa-arrow-down text-xl"></i>
            </a>
        </div>
    </section>

    <section id="about" class="py-24 bg-[#0a0a0a]">
        <div class="container mx-auto p-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">About <span class="text-blue-500">Me</span></h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto rounded-full"></div>
            </div>

            <div class="glass-card p-8 md:p-12 rounded-3xl grid md:grid-cols-12 gap-12 items-start" data-aos="fade-up" data-aos-delay="100">
                <div class="md:col-span-5 lg:col-span-4 relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10 relative group">
                        <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
                        <img  loading="lazy" src="{{ $about && $about->foto ? asset('storage/about/'.$about->foto) : asset('img/adli.jpg') }}" alt="About Image" class="w-full h-auto transform transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-[#111] border border-white/10 p-4 rounded-xl shadow-xl hidden md:block">
                        <p class="text-3xl font-bold text-blue-500"><span data-counter="{{ optional($about)->total_project ?? 100 }}">0</span>+</p>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Projects Done</p>
                    </div>
                </div>

                <div class="md:col-span-7 lg:col-span-8 space-y-6">
                    <h3 class="text-2xl font-bold text-white">{{ optional($profile)->nama ?? 'Naufal Syahruradli' }}</h3>
                    <p class="text-blue-400 font-medium">{{ optional($about)->subjudul ?? 'Backend Developer' }}</p>

                    <div class="text-gray-400 leading-relaxed text-justify space-y-4">
                        {!! strip_tags(optional($about)->deskripsi, '<p><br><strong><em><ul><ol><li><a><h1><h2><h3><h4><span>') !!}
                    </div>

                    <div class="pt-4">
                        <h4 class="text-white font-semibold mb-4">Core Competencies</h4>
                        <div class="flex flex-wrap gap-3">
                            @if($competencies)
                                @php
                                    $colors = ['blue', 'purple', 'green', 'red', 'yellow', 'indigo', 'teal'];
                                @endphp

                                @foreach($competencies as $skill)
                                    @php
                                        $color = $colors[$loop->index % count($colors)];
                                    @endphp
                                    <span class="px-4 py-2 bg-{{ $color }}-500/10 border border-{{ $color }}-500/50 text-{{ $color }}-300 rounded-lg text-sm">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tech" class="py-24 bg-[#050505] relative overflow-hidden">
        <div class="absolute right-0 top-1/4 w-96 h-96 bg-blue-900/20 rounded-full blur-[100px] -z-10"></div>
        <div class="container mx-auto p-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Tools & <span class="text-blue-500">Technologies</span></h2>
                <p class="text-gray-400">The arsenal I use to build and break things.</p>
            </div>

           <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($techs as $index => $tech)
                <div class="glass-card p-6 rounded-xl flex flex-col items-center justify-center gap-4 group border border-transparent hover:bg-white/5 hover:!border-blue-500/50 hover:-translate-y-2 transition-all duration-300"
                    data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">

                    <div class="w-16 h-16 flex items-center justify-center bg-white/5 rounded-full group-hover:scale-110 transition-transform duration-300">
                        <img  loading="lazy" src="{{ asset('storage/tech/'.$tech->foto) }}" class="w-10 h-10 object-contain" alt="{{ $tech->judul }}">
                    </div>
                    <h3 class="text-gray-300 font-medium group-hover:text-white text-sm">{{ $tech->judul }}</h3>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="experience" class="py-24 bg-[#0a0a0a] relative">
        <div class="container mx-auto p-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">My <span class="text-blue-500">Journey</span></h2>
                <p class="text-gray-400">Work Experience</p>
            </div>

            <div class="relative timeline-line max-w-4xl mx-auto">
                @foreach($experiences as $index => $exp)
                    @php
                        $colors = ['blue', 'purple', 'green', 'red', 'yellow'];
                        $colorName = $colors[$index % count($colors)];

                        // Mapping nama warna ke Hex Code asli Tailwind
                        $hexColors = [
                            'blue'   => '#3b82f6',
                            'purple' => '#a855f7',
                            'green'  => '#22c55e',
                            'red'    => '#ef4444',
                            'yellow' => '#eab308'
                        ];
                        $hex = $hexColors[$colorName];
                    @endphp

                    <div class="relative pl-16 lg:pl-0 py-6 group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="lg:flex items-center justify-between gap-10 {{ $index % 2 != 0 ? 'flex-row-reverse' : '' }}">

                            <div class="hidden lg:block w-1/2 {{ $index % 2 != 0 ? 'text-left pl-10' : 'text-right pr-10' }}">
                                <h4 class="text-2xl font-bold text-{{ $colorName }}-500">{{ $exp->tahun }}</h4>
                            </div>

                            <div class="absolute left-4 lg:left-1/2 top-8 w-4 h-4 rounded-full border-4 border-[#0a0a0a] transform -translate-x-1/2 z-10 bg-{{ $colorName }}-600"
                                style="box-shadow: 0 0 10px {{ $hex }}80;"> </div>

                            <div class="lg:w-1/2 {{ $index % 2 != 0 ? 'lg:pr-10' : 'lg:pl-10' }}">
                                <h4 class="lg:hidden text-xl font-bold text-{{ $colorName }}-500 mb-1">{{ $exp->tahun }}</h4>

                                <div class="glass-card p-6 rounded-xl hover:bg-white/5 transition-colors"
                                    style="border-left: 4px solid {{ $hex }};">

                                    <h3 class="text-xl font-bold text-white">{{ $exp->judul }}</h3>
                                    <p class="text-gray-400 mt-2 text-sm leading-relaxed">{{ $exp->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#050505] h-auto flex justify-center pb-20 relative overflow-hidden pt-10" id="project">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[128px] -z-10"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[128px] -z-10"></div>

        <div class="container p-4 z-10">
            <div class="items-center text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Featured <span class="text-blue-500">Projects</span></h2>
                <p class="text-gray-400">My Projects</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 p-4">
                @foreach($projects as $index => $project)

                    @php
                        $isLarge = ($index % 3 == 0);
                        $colors = [
                                'Web Development' => 'blue',
                                'IoT' => 'green',
                                'Cyber Security' => 'red',
                                'Mobile App' => 'yellow'
                            ];
                            // Default ke blue jika kategori tidak dikenali
                            $color = $colors[$project->type] ?? 'blue';
                        $imgSrc = $project->galery[0] ?? 'default.png';
                    @endphp

                    @if($isLarge)
                        <div class="md:col-span-2 flex flex-col md:flex-row gap-6 justify-center p-6 rounded-2xl glass-card hover:border-{{ $index % 2 != 0 ? 'yellow' : 'blue' }}-500/30 hover:shadow-lg hover:shadow-{{ $index % 2 != 0 ? 'yellow' : 'blue' }}-900/20 transition-all duration-300"
                            data-aos="fade-up" data-aos-delay="100" data-tilt data-tilt-glare data-tilt-max-glare="0.2">

                            <div class="md:w-1/2 {{ $index % 2 != 0 ? 'order-1 md:order-2' : '' }}">
                                <img  loading="lazy" src="{{ asset('storage/project/'.$imgSrc) }}" class="w-full h-64 md:h-80 rounded-xl shadow-lg object-cover" alt="{{ $project->judul }}">
                            </div>

                            <div class="md:w-1/2 flex flex-col justify-center space-y-4 {{ $index % 2 != 0 ? 'order-2 md:order-1 text-left md:text-right' : '' }}">
                                <h2 class="text-2xl font-bold text-white">{{ $project->judul }}</h2>
                                <p class="text-gray-400 leading-relaxed text-sm text-justify {{ $index % 2 != 0 ? 'md:text-right' : '' }}">
                                    {{ Str::limit($project->deskripsi, 150) }}
                                </p>

                                <div class="flex gap-2 flex-wrap {{ $index % 2 != 0 ? 'justify-start md:justify-end' : '' }}">
                                    @if($project->teknologi)
                                        @foreach(array_slice($project->teknologi, 0, 3) as $stack)
                                            <span class="text-xs px-2 py-1 bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-300 rounded">{{ $stack }}</span>
                                        @endforeach
                                    @endif
                                    @if(count($project->teknologi) > 3)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/5 border border-white/10 text-gray-400" title="{{ implode(', ', array_slice($project->teknologi, 3)) }}">
                                            +{{ count($project->teknologi) - 3 }}
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('projects.show', $project->slug) }}" class="text-{{ $index % 2 != 0 ? 'yellow' : 'blue' }}-400 font-semibold text-sm hover:text-{{ $color }}-300 flex items-center gap-2 group pt-2 {{ $index % 2 != 0 ? 'justify-start md:justify-end' : '' }}">
                                    See Project <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>

                    @else
                        <div class="flex flex-col gap-4 p-6 rounded-2xl glass-card hover:border-{{ $color }}-500/30 hover:shadow-lg hover:shadow-{{ $color }}-900/20 transition-all duration-300"
                            data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-delay="200" data-tilt data-tilt-glare data-tilt-max-glare="0.2">

                            <div class="w-full">
                                <img  loading="lazy" src="{{ asset('storage/project/'.$imgSrc) }}" class="w-full h-48 rounded-xl shadow-lg object-cover" alt="{{ $project->judul }}">
                            </div>

                            <div class="flex flex-col justify-between flex-grow space-y-3">
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $project->judul }}</h2>
                                    <p class="text-gray-400 text-sm mt-2 line-clamp-3 text-justify">
                                        {{ Str::limit($project->deskripsi, 100) }}
                                    </p>
                                </div>

                                <div class="flex gap-2 flex-wrap">
                                    @if($project->teknologi)
                                        @foreach(array_slice($project->teknologi, 0, 3) as $stack) {{-- Batasi max 3 badge biar rapi --}}
                                            <span class="text-xs px-2 py-1 bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-300 rounded">{{ $stack }}</span>
                                        @endforeach
                                    @endif
                                    @if(count($project->teknologi) > 3)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/5 border border-white/10 text-gray-400" title="{{ implode(', ', array_slice($project->teknologi, 3)) }}">
                                            +{{ count($project->teknologi) - 3 }}
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('projects.show', $project->slug) }}" class="text-{{ $color }}-400 font-semibold text-sm hover:text-{{ $color }}-300 flex items-center gap-2 group">
                                    See Project <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                @endforeach
            </div>

            <div class="pt-10 text-center" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('projects.index') }}" class="inline-block px-8 py-3 rounded-full border border-gray-600 hover:border-white text-gray-300 hover:text-white transition-all hover:bg-white/5 group">
                    See more projects <i class="fas fa-angle-double-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="bg-[#050505] py-20 relative overflow-hidden" id="achievements">
        <div class="container mx-auto p-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Certifications & <span class="text-blue-500">Awards</span></h2>
                <p class="text-gray-400">My Certifications</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($certificates as $index => $cert)
                <div class="glass-card rounded-2xl relative group hover:-translate-y-2 transition-transform duration-300 h-full flex flex-col overflow-hidden"
                    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    <div class="relative h-48 w-full overflow-hidden">
                        <div class="absolute top-3 right-3 z-10 bg-black/60 backdrop-blur-md border border-white/10 px-3 py-1 rounded-full">
                            <span class="text-xs font-mono text-blue-400 font-bold">
                                {{ \Carbon\Carbon::parse($cert->tanggal)->year }}
                            </span>
                        </div>

                        <img  loading="lazy" src="{{ asset('storage/certificate/' . ($cert->foto ?? 'default.jpg')) }}"
                            alt="{{ $cert->judul }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 opacity-80 group-hover:opacity-100">

                        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-transparent to-transparent opacity-60"></div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow relative">
                        <div class="absolute -top-6 left-6 w-12 h-12 rounded-xl flex items-center justify-center text-xl bg-[#0a0a0a] border border-white/10 text-blue-400 shadow-lg">
                            @if ($cert->type == 'Award')
                                <i class="fas fa-award"></i>
                            @elseif ($cert->type == 'Certificate')
                                <i class="fas fa-trophy"></i>
                            @elseif ($cert->type == 'Competency')
                                <i class="fas fa-certificate"></i>
                            @endif
                        </div>

                        <div class="mt-4 flex-grow">
                            <h3 class="text-lg font-bold text-white mb-1 group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $cert->judul }}
                            </h3>
                            <p class="text-sm text-blue-500 font-medium mb-3">{{ $cert->issued }}</p>
                            <p class="text-sm text-gray-400 leading-relaxed line-clamp-3">
                                {{ Str::limit($cert->deskripsi, 80) }}
                            </p>
                        </div>

                        <div class="pt-6 mt-auto border-t border-white/5">
                            <a href="{{ route('certificate.show', $cert->slug) }}" class="inline-flex items-center text-sm text-gray-400 hover:text-white transition-colors group/link">
                                View Credential
                                <i class="fas fa-arrow-right ml-2 transition-transform group-hover/link:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-16 text-center" data-aos="zoom-in">
                <div class="inline-block p-[1px] rounded-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500">
                    <a href="{{ asset('storage/cv/'. $profile->cv) }}" target="_blank" class="block px-8 py-3 rounded-full bg-[#0a0a0a] text-white font-semibold hover:bg-transparent transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-download"></i> Download Full Resume
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonial Section --}}
    <section class="bg-[#0a0a0a] py-20" id="testimonials">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">What People <span class="text-blue-500">Say</span></h2>
                <p class="text-gray-400">Feedback from clients and colleagues</p>
            </div>

            <div class="testimonial-slider" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-track" id="testimonialTrack">
                    @if($testimonials->isNotEmpty())
                        @foreach($testimonials as $testimonial)
                            <div class="testimonial-card">
                                <div class="glass-card p-8 rounded-2xl h-full">
                                    <div class="flex items-center gap-1 mb-4">
                                        @for($i = 0; $i < $testimonial->rate; $i++)
                                            <i class="fas fa-star text-yellow-500"></i>
                                        @endfor
                                        @for($i = $testimonial->rate; $i < 5; $i++)
                                            <i class="fas fa-star text-gray-600"></i>
                                        @endfor
                                    </div>
                                    <p class="text-gray-400 mb-6 italic">"{{ $testimonial->testimonial }}"</p>
                                    <div class="flex items-center gap-4">
                                        @if($testimonial->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($testimonial->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-white font-semibold">{{ $testimonial->name }}</h4>
                                            <p class="text-gray-500 text-sm">{{ $testimonial->position }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-400 col-span-full">No testimonials yet.</div>
                    @endif
                </div>

                {{-- Navigation Dots --}}
                <div class="testimonial-dots" id="testimonialDots"></div>

                {{-- Navigation Arrows --}}
                <div class="flex justify-center gap-4 mt-6">
                    <button id="prevTestimonial" class="w-12 h-12 rounded-full border border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 transition-all flex items-center justify-center">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="nextTestimonial" class="w-12 h-12 rounded-full border border-gray-700 text-gray-400 hover:border-blue-500 hover:text-blue-500 transition-all flex items-center justify-center">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#050505] pb-20 pt-20" id="contact">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Get in <span class="text-blue-500">Touch</span></h2>
                <p class="text-gray-400">Have a project in mind or just want to say hi?</p>
            </div>

            <div class="glass-card p-8 md:p-10 rounded-3xl shadow-2xl" data-aos="zoom-in">
                <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-300">Name</label>
                            <input type="text" id="name" name="name" class="glass-input w-full p-4 rounded-xl text-sm" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Email</label>
                            <input type="email" id="email" name="email" class="glass-input w-full p-4 rounded-xl text-sm" placeholder="john@example.com" required>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-300">Message</label>
                        <textarea id="message" name="message" rows="5" class="glass-input w-full p-4 rounded-xl text-sm" placeholder="Tell me about your project..." required></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-1">
                        Send Message <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // TypeIt for roles
            const roles = {!! json_encode(optional($profile)->role) !!};

            new TypeIt("#role", {
                strings: roles,
                speed: 100,
                breakLines: false,
                autoStart: true,
                loop: true,
                deleteSpeed: 50,
                nextStringDelay: 500,
                waitUntilVisible: true
            }).go();

            // Testimonial Slider
            const track = document.getElementById('testimonialTrack');
            const dotsContainer = document.getElementById('testimonialDots');
            const prevBtn = document.getElementById('prevTestimonial');
            const nextBtn = document.getElementById('nextTestimonial');

            if (track && dotsContainer) {
                const cards = track.querySelectorAll('.testimonial-card');
                let currentIndex = 0;
                let cardsPerView = getCardsPerView();
                let totalSlides = Math.ceil(cards.length / cardsPerView);

                function getCardsPerView() {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 768) return 2;
                    return 1;
                }

                function createDots() {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < totalSlides; i++) {
                        const dot = document.createElement('div');
                        dot.classList.add('testimonial-dot');
                        if (i === 0) dot.classList.add('active');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }
                }

                function updateDots() {
                    const dots = dotsContainer.querySelectorAll('.testimonial-dot');
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('active', i === currentIndex);
                    });
                }

                function goToSlide(index) {
                    currentIndex = index;
                    const cardWidth = 100 / cardsPerView;
                    const offset = currentIndex * cardsPerView * cardWidth;
                    track.style.transform = `translateX(-${offset}%)`;
                    updateDots();
                }

                function nextSlide() {
                    currentIndex = (currentIndex + 1) % totalSlides;
                    goToSlide(currentIndex);
                }

                function prevSlide() {
                    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                    goToSlide(currentIndex);
                }

                // Event Listeners
                if (nextBtn) nextBtn.addEventListener('click', nextSlide);
                if (prevBtn) prevBtn.addEventListener('click', prevSlide);

                // Auto slide every 5 seconds
                let autoSlide = setInterval(nextSlide, 5000);

                // Pause on hover
                track.addEventListener('mouseenter', () => clearInterval(autoSlide));
                track.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(nextSlide, 5000);
                });

                // Handle resize
                window.addEventListener('resize', () => {
                    cardsPerView = getCardsPerView();
                    totalSlides = Math.ceil(cards.length / cardsPerView);
                    currentIndex = 0;
                    createDots();
                    goToSlide(0);
                });

                // Initialize
                createDots();
            }
        });
    </script>
@endpush
