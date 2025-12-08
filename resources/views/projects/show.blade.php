@extends('layouts.app')

@section('title', $project->judul . ' | Project Detail')
@section('meta_description', Str::limit(strip_tags($project->deskripsi), 160))
@section('meta_keywords', implode(', ', $project->teknologi ?? []) . ', ' . $project->type . ', Portfolio Project')
@section('og_image', asset('storage/project/' . ($project->galery[0] ?? 'default.png')))

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "name": "{{ $project->judul }}",
    "description": "{{ Str::limit(strip_tags($project->deskripsi), 200) }}",
    "image": "{{ asset('storage/project/' . ($project->galery[0] ?? 'default.png')) }}",
    "url": "{{ url()->current() }}",
    "author": {
        "@type": "Person",
        "name": "Naufal Syahruradli"
    },
    "genre": "{{ $project->type }}",
    "keywords": "{{ implode(', ', $project->teknologi ?? []) }}"
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}"},
        {"@type": "ListItem", "position": 2, "name": "Projects", "item": "{{ route('projects.index') }}"},
        {"@type": "ListItem", "position": 3, "name": "{{ $project->judul }}", "item": "{{ url()->current() }}"}
    ]
}
</script>
@endsection

@section('content')
    @php
        // Logika Warna dan Gambar
        $imgSrc = $project->galery[0] ?? 'default.png';

        $colors = [
            'Web Development' => 'blue',
            'IoT' => 'green',
            'Cyber Security' => 'red',
            'Mobile App' => 'yellow'
        ];
        $color = $colors[$project->type] ?? 'blue';
    @endphp

    <div class="w-full h-[50vh] relative mt-16">
        <img loading="lazy" src="{{ asset('storage/project/'.$imgSrc) }}" class="w-full h-full object-cover" alt="{{ $project->judul }}">
        <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/50 to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 container mx-auto">
            <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-white mb-4 inline-flex items-center gap-2 text-sm transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
            <div class="block"></div>
            <span class="px-4 py-1.5 rounded-full bg-{{ $color }}-600 text-white text-sm font-semibold mb-4 inline-block">
                {{ $project->type }}
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-2" data-aos="fade-up">{{ $project->judul }}</h1>
        </div>
    </div>

    <section class="py-12">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-3 gap-12">

                <div class="lg:col-span-2 space-y-8" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-4">Overview</h2>
                        <div class="text-gray-400 leading-relaxed text-justify space-y-4">
                            {!! nl2br(e($project->deskripsi)) !!}
                        </div>
                    </div>

                    @if($project->fitur && count($project->fitur) > 0)
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-4">Key Features</h2>
                        <ul class="space-y-3 text-gray-400">
                            @foreach($project->fitur as $feature)
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-{{ $color }}-500 mt-1"></i>
                                <span>{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($project->galery && count($project->galery) > 0)
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-4">Gallery</h2>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($project->galery as $img)
                                <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-white/10"
                                    onclick="openModal('{{ asset('storage/project/'.$img) }}', '{{ $project->judul }}')">

                                    <img loading="lazy" src="{{ asset('storage/project/'.$img) }}"
                                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                                        alt="Gallery Image">

                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <i class="fas fa-expand text-white text-2xl"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-1">
                    <div class="glass-card p-6 rounded-2xl sticky top-24" data-aos="fade-left" data-aos-delay="200">
                        <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Project Info</h3>

                        <div class="space-y-6">
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Client</p>
                                <p class="text-white font-medium">{{ $project->client ?? 'Personal Project' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Role</p>
                                <p class="text-white font-medium">{{ $project->role ?? 'Fullstack Developer' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm mb-1">Date</p>
                                <p class="text-white font-medium">
                                    {{ \Carbon\Carbon::parse($project->tanggal)->format('F Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm mb-2">Technologies</p>
                                <div class="flex flex-wrap gap-2">
                                    @if($project->teknologi)
                                        @foreach($project->teknologi as $tech)
                                        <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-xs text-{{ $color }}-300">
                                            {{ $tech }}
                                        </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            @if($project->website)
                            <a href="{{ $project->website }}" target="_blank" class="flex items-center justify-center w-full py-3 bg-{{ $color }}-600 hover:bg-{{ $color }}-700 text-white font-bold rounded-xl transition-all shadow-lg">
                                View Live Site <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                            @endif

                            @if($project->source)
                            <a href="{{ $project->source }}" target="_blank" class="flex items-center justify-center w-full py-3 border border-gray-600 hover:border-white text-gray-300 hover:text-white rounded-xl transition-all">
                                <i class="fab fa-github mr-2"></i> Source Code
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
