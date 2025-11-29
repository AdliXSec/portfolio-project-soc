@extends('layouts.app')

@section('title', 'All Projects | Naufal Adli')

@section('content')
    <section class="pt-32 pb-12 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-blue-600/20 rounded-full blur-[120px] -z-10"></div>

        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" data-aos="fade-down">My <span class="text-blue-500">Portfolio</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="100">
                Explore the projects I've worked on, ranging from Web Development, IoT systems, to Cyber Security tools.
            </p>

            <form action="{{ route('projects.index') }}" method="GET" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-4" data-aos="fade-up" data-aos-delay="200">
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}" maxlength="50" placeholder="Search projects..." class="w-full pl-12 pr-4 py-3 rounded-xl glass-card text-white focus:outline-none focus:border-blue-500 transition-colors">
                </div>
                <select name="category" onchange="this.form.submit()" class="px-6 py-3 rounded-xl glass-card text-gray-300 focus:outline-none focus:border-blue-500 cursor-pointer bg-[#050505]">
                    <option value="">All Categories</option>
                    <option value="Web Development" {{ request('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                    <option value="IoT" {{ request('category') == 'IoT' ? 'selected' : '' }}>IoT</option>
                    <option value="Cyber Security" {{ request('category') == 'Cyber Security' ? 'selected' : '' }}>Cyber Security</option>
                    <option value="Mobile App" {{ request('category') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                </select>
            </form>
        </div>
    </section>

    <section class="pb-24">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($projects as $index => $project)
                    @php
                        // 1. Logic Gambar (Ambil index ke-0 dari JSON galery)
                        $imgSrc = $project->galery[0] ?? 'img/project/p1.png';

                        // 2. Logic Warna Berdasarkan Kategori (Manual Mapping)
                        $colors = [
                            'Web Development' => 'blue',
                            'IoT' => 'green',
                            'Cyber Security' => 'red',
                            'Mobile App' => 'yellow'
                        ];
                        // Default ke blue jika kategori tidak dikenali
                        $color = $colors[$project->type] ?? 'blue';
                    @endphp

                    <div class="glass-card rounded-2xl overflow-hidden group hover:-translate-y-2 hover:border-{{ $color }}-500/50 transition-all duration-300 border border-white/5"
                         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <div class="relative h-48 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#050505] to-transparent z-10 opacity-60"></div>

                            <img src="{{ asset('img/project/'.$imgSrc) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $project->judul }}">

                            <div class="absolute top-4 right-4 z-20">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $color }}-500/20 text-{{ $color }}-300 border border-{{ $color }}-500/30 backdrop-blur-md">
                                    {{ $project->type }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $project->judul }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($project->deskripsi, 100) }}</p>

                            <div class="flex flex-wrap gap-2 mb-6 items-center">
                                @if($project->teknologi)
                                    {{-- Ambil hanya 3 item pertama --}}
                                    @foreach(array_slice($project->teknologi, 0, 3) as $tech)
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-300">
                                            {{ $tech }}
                                        </span>
                                    @endforeach

                                    {{-- Jika lebih dari 3, tampilkan sisa jumlahnya --}}
                                    @if(count($project->teknologi) > 3)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/5 border border-white/10 text-gray-400" title="{{ implode(', ', array_slice($project->teknologi, 3)) }}">
                                            +{{ count($project->teknologi) - 3 }}
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <a href="{{ route('projects.show', $project->slug) }}" class="block w-full py-3 text-center rounded-lg border border-gray-700 text-gray-300 hover:bg-white/5 hover:text-white hover:border-{{ $color }}-500 transition-all">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-block p-4 rounded-full bg-white/5 mb-4">
                            <i class="fas fa-folder-open text-4xl text-gray-500"></i>
                        </div>
                        <h3 class="text-xl text-white font-semibold">No projects found</h3>
                        <p class="text-gray-500">Try adjusting your search or filter.</p>
                    </div>
                @endforelse

            </div>

            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        </div>
    </section>
@endsection
