@extends('layouts.app')

@section('title', $certificate->judul . ' | Certification')
@section('meta_description', 'Certificate: ' . $certificate->judul . ' issued by ' . $certificate->penerbit . '. ' . Str::limit($certificate->deskripsi ?? '', 100))
@section('meta_keywords', $certificate->judul . ', ' . $certificate->penerbit . ', ' . $certificate->type . ', Certificate, Achievement')
@section('og_image', asset('storage/certificate/' . $certificate->foto))

@section('content')
    @php
        // Mapping warna berdasarkan Tipe jika kolom color kosong
        $colors = [
            'Award' => 'yellow',
            'Certificate' => 'blue',
            'Competency' => 'green'
        ];
        $color = $certificate->color ?? $colors[$certificate->type] ?? 'blue';
    @endphp

    <div class="fixed top-0 left-0 w-full h-full bg-[url('{{ asset('img/grid-pattern.svg') }}')] opacity-5 -z-20 pointer-events-none"></div>
    <div class="fixed top-20 right-[-10%] w-[500px] h-[500px] bg-{{ $color }}-600/10 rounded-full blur-[128px] -z-10"></div>

    <section class="pt-32 pb-20 container mx-auto px-6">

        <div class="text-sm text-gray-500 mb-8 flex items-center gap-2" data-aos="fade-right">
            <a href="{{ route('home') }}" class="hover:text-blue-400">Home</a>
            <span class="text-gray-700">/</span>
            <a href="{{ route('home') }}#achievements" class="hover:text-blue-400">Certifications</a>
            <span class="text-gray-700">/</span>
            <span class="text-white truncate max-w-[200px]">{{ $certificate->judul }}</span>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-start">

            <div class="lg:col-span-7" data-aos="fade-up">
                <div class="relative group rounded-2xl overflow-hidden border border-white/10 bg-[#111] p-2 shadow-2xl">
                    <div class="relative rounded-xl overflow-hidden">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-all duration-500 z-10"></div>
                        <img loading="lazy" src="{{ asset('storage/certificate/'.$certificate->foto) }}" alt="{{ $certificate->judul }}" class="w-full h-auto object-cover transform group-hover:scale-[1.02] transition-transform duration-500">
                    </div>
                    <div class="absolute bottom-6 right-6 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-12 h-12 rounded-full bg-black/50 backdrop-blur-md text-white border border-white/20 flex items-center justify-center hover:bg-{{ $color }}-600 hover:border-{{ $color }}-600 transition-colors">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 space-y-8" data-aos="fade-left" data-aos-delay="100">

                <div>
                    <span class="px-3 py-1 rounded-full bg-{{ $color }}-500/10 border border-{{ $color }}-500/20 text-{{ $color }}-400 text-xs font-bold uppercase tracking-wider mb-4 inline-block">
                        {{ $certificate->type }}
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-2">
                        {{ $certificate->judul }}
                    </h1>
                    <p class="text-lg text-blue-500 font-medium">
                        Issued by {{ $certificate->issued }}
                    </p>
                </div>

                <div class="glass-card rounded-xl p-6">
                    <div class="grid grid-cols-2 gap-y-6">
                        <div>
                            <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Issue Date</p>
                            <p class="text-white font-medium">{{ \Carbon\Carbon::parse($certificate->tanggal)->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Credential ID</p>
                            <p class="text-white font-mono text-sm">{{ $certificate->kredensial ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Status</p>
                            <span class="inline-flex items-center gap-1.5 text-green-400 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> {{ $certificate->status ?? 'Valid' }}
                            </span>
                        </div>
                        <div>
                             <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">Type</p>
                             <p class="text-white text-sm capitalize">{{ $certificate->type }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-3">About this Achievement</h3>
                    <p class="text-gray-400 leading-relaxed text-justify text-sm">
                        {{ $certificate->deskripsi }}
                    </p>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-3">Skills Validated</h3>
                    <div class="flex flex-wrap gap-2">
                        @if($certificate->skill)
                            @foreach($certificate->skill as $skill)
                                <span class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-gray-300 text-xs hover:bg-white/10 hover:text-white transition-colors cursor-default">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row gap-4">
                    @if($certificate->link && $certificate->link != '#')
                    <a href="{{ $certificate->link }}" target="_blank" class="flex-1 px-6 py-3.5 rounded-xl bg-white text-black font-bold text-center hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                        Verify Credential <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                    @else
                    <button disabled class="flex-1 px-6 py-3.5 rounded-xl bg-gray-700 text-gray-400 font-bold text-center cursor-not-allowed flex items-center justify-center gap-2">
                        No Verification Link
                    </button>
                    @endif
                </div>

            </div>
        </div>
    </section>

    @if(isset($related_certificates) && $related_certificates->count() > 0)
    <section class="py-12 border-t border-white/5 bg-[#0a0a0a]">
        <div class="container mx-auto px-6">
            <h3 class="text-white font-bold text-xl mb-8">Other Achievements</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($related_certificates as $related)
                    @php
                        // Mapping warna manual untuk related items
                        $relatedColor = $related->color ?? $colors[$related->type] ?? 'blue';
                    @endphp
                    <a href="{{ route('certificate.show', $related->slug) }}" class="glass-card p-4 rounded-xl flex items-center gap-4 hover:bg-white/5 transition group">
                        <div class="w-12 h-12 rounded-lg bg-{{ $relatedColor }}-500/10 text-{{ $relatedColor }}-400 flex items-center justify-center text-xl">
                            <i class="fas {{ $related->icon ?? ($related->type == 'Award' ? 'fa-trophy' : 'fa-certificate') }}"></i>
                        </div>
                        <div>
                            <h4 class="text-white font-medium text-sm group-hover:text-{{ $relatedColor }}-400 transition line-clamp-1">{{ $related->judul }}</h4>
                            <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($related->tanggal)->year }} • {{ Str::limit($related->issued, 20) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
