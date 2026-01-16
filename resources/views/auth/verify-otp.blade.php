@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('content')
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-[#f0fdf4] rounded-full mb-6 relative group">
            <div class="absolute inset-0 bg-[#0f392b]/10 rounded-full animate-ping opacity-20"></div>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10 text-[#0f392b] group-hover:scale-110 transition-transform duration-300" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 19v-8.93a2 2 0 01.89-1.664l7.171-5.123a2 2 0 012.35 0l7.171 5.122A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
            </svg>
        </div>

        <h3 class="text-3xl text-[#0f392b] mb-2">Verifikasi Email</h3>
        <p class="text-gray-500">
            Kode OTP telah dikirim ke <br>
            <span class="font-bold text-gray-800 bg-gray-100 px-3 py-1 rounded-lg mt-2 inline-block">
                {{ session('email') ?? old('email') }}
            </span>
        </p>
    </div>

    <form action="{{ route('auth.otp.submit') }}" method="POST" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">

        <div class="space-y-6">
            <div>
                <label class="block text-center text-xs font-bold text-[#c5a059] uppercase tracking-widest mb-3">
                    Masukkan 6 Digit Kode
                </label>

                <div class="relative max-w-[300px] mx-auto">
                    <input type="text" name="otp" required autofocus maxlength="6" inputmode="numeric"
                        autocomplete="one-time-code"
                        class="w-full text-center text-4xl font-bold tracking-[0.5em] py-4 rounded-2xl bg-white border-2 border-gray-200 text-[#0f392b] focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300 shadow-sm placeholder-gray-200"
                        placeholder="000000" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                @error('otp')
                    <p class="text-red-500 text-sm text-center mt-3 bg-red-50 py-1 px-3 rounded-lg inline-block">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex justify-center">
                <div
                    class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-full border border-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Sisa waktu: <span id="timer" class="font-bold text-[#0f392b]">10:00</span></span>
                </div>
            </div>

            <button type="submit" id="btnSubmit"
                class="w-full bg-[#0f392b] hover:bg-[#09221a] text-white font-semibold py-4 rounded-xl shadow-lg shadow-[#0f392b]/30 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">

                {{-- Text Normal --}}
                <span id="btnText">Verifikasi</span>

                {{-- Loading Spinner --}}
                <span class="hidden flex items-center gap-2" id="btnLoading">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Memproses...</span>
                </span>
            </button>
        </div>
    </form>

    <div class="mt-8 text-center space-y-4">
        <a href="{{ route('auth.register') }}" class="block text-gray-400 text-xs hover:text-gray-600 transition-colors">
            Salah alamat email? Daftar ulang
        </a>
    </div>

    <script>
        // --- Timer Logic ---
        let timeLeft = 600;
        const timerElement = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');
        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerElement.textContent = '00:00';
                timerElement.classList.add('text-red-500');
            }
            timeLeft--;
        }, 1000);


        // Fungsi helper untuk menampilkan loading
        function showLoading() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const loading = document.getElementById('btnLoading');

            if (btn && text && loading) {
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                text.classList.add('hidden');
                loading.classList.remove('hidden');
            }
        }

        // 1. Handle ketika user menekan tombol Enter atau Klik tombol
        document.getElementById('otpForm').addEventListener('submit', function() {
            showLoading();
        });

        // 2. Handle Auto-Submit saat 6 digit terisi
        document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
            if (this.value.length === 6) {
                // Munculkan loading dulu
                showLoading();

                // Submit setelah jeda sangat singkat agar UI sempat update
                setTimeout(() => document.getElementById('otpForm').submit(), 300);
            }
        });
    </script>
@endsection
