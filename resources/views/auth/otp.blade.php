<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify OTP | Naufal Adli</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: #e5e7eb; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); }
        /* Style khusus untuk kotak OTP */
        .otp-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            text-align: center;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .otp-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }
        /* Menghilangkan spin button pada input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-[128px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[128px] -z-10"></div>

    <a href="{{ route('login') }}" class="absolute top-6 left-6 text-gray-400 hover:text-white transition flex items-center gap-2 group">
        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Back to Login
    </a>

    <div class="w-full max-w-md p-8 mx-4 glass-card rounded-2xl">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl mx-auto mb-4 shadow-lg shadow-purple-900/50">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">Two-Factor Auth</h2>
            <p class="text-gray-400 text-sm mt-2">Enter the 6-digit code sent to your email <br> <span class="text-blue-400">{{ $email ?? 'your email' }}</span></p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 text-red-400 text-sm rounded-lg text-center">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 text-green-400 text-sm rounded-lg text-center">
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
                           oninput="handleInput(this)" onkeydown="handleKeyDown(this, event)" onpaste="handlePaste(event)">
                @endfor
            </div>

            @error('otp')
                <p class="text-red-400 text-xs text-center mt-1">{{ $message }}</p>
            @enderror

            <div class="text-center text-sm text-gray-400">
                Didn't receive the code?
                <a href="#" onclick="event.preventDefault(); document.getElementById('resend-form').submit();" class="text-blue-500 hover:text-blue-400 font-medium transition ml-1 hover:underline">Resend Code</a>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold shadow-lg shadow-blue-500/20 transition-all transform hover:-translate-y-1">
                Verify & Proceed
            </button>
        </form>

        <form id="resend-form" action="{{ route('otp.resend') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <script>
        // Logika untuk Input OTP
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('full_otp_value');
        const form = document.getElementById('otpForm');

        // Fungsi saat mengetik
        function handleInput(input) {
            // Hanya izinkan angka
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value.length === 1) {
                const nextInput = input.nextElementSibling;
                if (nextInput) {
                    nextInput.focus();
                }
            }
            updateHiddenInput();
        }

        // Fungsi navigasi keyboard (Backspace & Arrow keys)
        function handleKeyDown(input, event) {
            if (event.key === 'Backspace' && input.value.length === 0) {
                const prevInput = input.previousElementSibling;
                if (prevInput) {
                    prevInput.focus();
                }
            }
        }

        // Fungsi Copy-Paste (User paste "123456")
        function handlePaste(event) {
            event.preventDefault();
            const pasteData = (event.clipboardData || window.clipboardData).getData('text');
            const numbers = pasteData.replace(/[^0-9]/g, ''); // Ambil hanya angka

            if (numbers.length > 0) {
                inputs.forEach((input, index) => {
                    if (index < numbers.length) {
                        input.value = numbers[index];
                    }
                });
                // Fokus ke kotak terakhir yang terisi atau kotak terakhir
                const focusIndex = Math.min(numbers.length, inputs.length) - 1;
                if (focusIndex >= 0 && focusIndex < inputs.length) {
                    inputs[focusIndex].focus();
                    // Jika paste 6 digit, otomatis submit (opsional, uncomment baris bawah jika ingin)
                    // if(numbers.length === 6) form.submit();
                }
                updateHiddenInput();
            }
        }

        // Menggabungkan value dari 6 kotak ke 1 hidden input untuk dikirim ke server
        function updateHiddenInput() {
            let fullOtp = '';
            inputs.forEach(input => fullOtp += input.value);
            hiddenInput.value = fullOtp;
        }

        // Fokus ke kotak pertama saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            inputs[0].focus();
        });

        // Update hidden input saat submit untuk memastikan data terkirim
        form.addEventListener('submit', (e) => {
            updateHiddenInput();
            if (hiddenInput.value.length < 6) {
                e.preventDefault();
                alert('Please enter all 6 digits.');
            }
        });
    </script>
</body>
</html>
