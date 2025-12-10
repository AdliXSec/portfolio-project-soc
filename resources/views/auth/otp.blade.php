@extends('layouts.auth')

@section('title', 'Two-Factor Authentication')

@push('styles')
<style>
    /* CSS Khusus untuk Input OTP */
    .otp-input {
        /* Default (Dark Mode) */
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    /* Override untuk Light Mode: Text Hitam */
    html:not(.dark) .otp-input {
        color: #1a1a1a !important;      /* Text Hitam */
        background: rgba(0, 0, 0, 0.05); /* Background abu tipis agar terlihat */
        border-color: rgba(0, 0, 0, 0.1);
    }

    .otp-input:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-2px);
    }

    /* Focus state untuk Light Mode */
    html:not(.dark) .otp-input:focus {
        background: white;
        border-color: #3b82f6;
    }

    /* Hapus spin button bawaan browser */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>
@endpush

@section('content')
<div class="w-full max-w-md p-8 mx-4 glass-card rounded-2xl relative z-10">
    <div class="text-center mb-8">
        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-purple-900/50">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Two-Factor Auth</h2>
        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
            Enter the 6-digit code sent to your email <br>
            <span class="text-blue-600 dark:text-blue-400 font-medium">{{ $email ?? 'your email' }}</span>
        </p>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-600 dark:text-red-400 text-sm rounded-lg text-center animate-pulse">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 text-green-600 dark:text-green-400 text-sm rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('otp.verify') }}" method="POST" id="otpForm" class="space-y-6">
        @csrf

        <input type="hidden" name="otp" id="full_otp_value">

        <div class="flex justify-between gap-2 sm:gap-3">
            @for ($i = 0; $i < 6; $i++)
                <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                       class="w-12 h-14 sm:w-14 sm:h-16 rounded-xl otp-input"
                       oninput="handleInput(this)"
                       onkeydown="handleKeyDown(this, event)"
                       onpaste="handlePaste(event)"
                       autocomplete="one-time-code">
            @endfor
        </div>

        @error('otp')
            <p class="text-red-500 dark:text-red-400 text-xs text-center mt-1">{{ $message }}</p>
        @enderror

        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
            Didn't receive the code?
            <a href="#" onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
               class="text-blue-600 dark:text-blue-500 hover:text-blue-500 dark:hover:text-blue-400 font-medium transition ml-1 hover:underline">
               Resend Code
            </a>
        </div>

        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-1">
            Verify & Proceed
        </button>
    </form>

    <form id="resend-form" action="{{ route('otp.resend') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi variabel
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('full_otp_value');
    const form = document.getElementById('otpForm');

    // Fokus ke kotak pertama saat load
    document.addEventListener('DOMContentLoaded', () => {
        if(inputs.length > 0) inputs[0].focus();
    });

    // Handle Input (Pindah otomatis ke kanan)
    function handleInput(input) {
        input.value = input.value.replace(/[^0-9]/g, ''); // Hanya angka

        if (input.value.length === 1) {
            const nextInput = input.nextElementSibling;
            if (nextInput) {
                nextInput.focus();
            }
        }
        updateHiddenInput();
    }

    // Handle Backspace (Pindah otomatis ke kiri)
    function handleKeyDown(input, event) {
        if (event.key === 'Backspace' && input.value.length === 0) {
            const prevInput = input.previousElementSibling;
            if (prevInput) {
                prevInput.focus();
            }
        }
    }

    // Handle Paste (Isi otomatis semua kotak)
    function handlePaste(event) {
        event.preventDefault();
        const pasteData = (event.clipboardData || window.clipboardData).getData('text');
        const numbers = pasteData.replace(/[^0-9]/g, '');

        if (numbers.length > 0) {
            inputs.forEach((input, index) => {
                if (index < numbers.length) {
                    input.value = numbers[index];
                }
            });

            // Fokus ke kotak terakhir yang terisi
            const focusIndex = Math.min(numbers.length, inputs.length) - 1;
            if (focusIndex >= 0 && focusIndex < inputs.length) {
                inputs[focusIndex].focus();
            }
            updateHiddenInput();
        }
    }

    // Update Hidden Input untuk dikirim ke server
    function updateHiddenInput() {
        let fullOtp = '';
        inputs.forEach(input => fullOtp += input.value);
        hiddenInput.value = fullOtp;
    }

    // Validasi sebelum submit
    form.addEventListener('submit', (e) => {
        updateHiddenInput();
        if (hiddenInput.value.length < 6) {
            e.preventDefault();
            alert('Please enter all 6 digits.');
        }
    });
</script>
@endpush
