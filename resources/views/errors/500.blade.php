@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')

    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-red-800/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-yellow-600/20 rounded-full blur-[120px]"></div>

    <div class="flex items-center justify-center min-h-screen relative z-10 p-6">

        <div class="text-center w-full max-w-lg glass-card p-10 rounded-2xl border border-white/10 shadow-xl" data-aos="zoom-in">

            <h1 class="text-9xl font-extrabold text-red-600 tracking-widest drop-shadow-lg">
                500
            </h1>

            <div class="bg-gray-800 text-white px-2 text-sm rounded-lg py-1.5 rotate-12 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 font-medium border border-red-600">
                SERVER ERROR
            </div>

            <p class="text-gray-400 mt-10 mb-8 text-lg">
                Mohon maaf, terjadi kesalahan internal server. Tim teknis sedang menangani masalah ini.
            </p>

            <a href="{{ route('home') }}" class="relative inline-block text-sm font-medium text-white group focus:outline-none focus:ring">
                <span class="absolute inset-0 translate-x-0.5 translate-y-0.5 bg-gray-600 transition-transform group-hover:translate-y-0 group-hover:translate-x-0"></span>
                <span class="relative block px-8 py-3 bg-gray-500 border border-current hover:bg-gray-600 transition-colors">
                    <i class="fas fa-home mr-2"></i> KEMBALI KE BERANDA
                </span>
            </a>

        </div>
    </div>
@endsection
