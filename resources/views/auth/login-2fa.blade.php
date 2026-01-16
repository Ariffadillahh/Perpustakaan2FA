@extends('layouts.auth')

@section('title', 'Verifikasi Keamanan')

@section('content')
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-[#f0fdf4] rounded-full mb-6 relative group">
            <div class="absolute inset-0 bg-[#0f392b]/10 rounded-full animate-ping opacity-20"></div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#0f392b]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>

        <h3 class="text-2xl font-bold text-[#0f392b] mb-2 font-serif">Autentikasi 2 Faktor</h3>
        <p class="text-gray-500">
            Akun Anda dilindungi. Masukkan kode 6 digit dari aplikasi <strong>Google Authenticator</strong>.
        </p>
    </div>

    <form action="{{ route('auth.login.2fa.verify') }}" method="POST" id="otpForm">
        @csrf

        <div class="space-y-6">
            <div>
                <div class="relative max-w-[300px] mx-auto">
                    <input type="text" name="otp" required autofocus maxlength="6" inputmode="numeric"
                        autocomplete="one-time-code"
                        class="w-full text-center text-4xl font-bold tracking-[0.5em] py-4 rounded-2xl bg-white border-2 border-gray-200 text-[#0f392b] focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all shadow-sm placeholder-gray-200"
                        placeholder="000000" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                @error('otp')
                    <p class="text-red-500 text-sm text-center mt-3">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3">

                <button type="submit" id="btnSubmit"
                    class="w-full bg-[#0f392b] hover:bg-[#09221a] text-white font-semibold py-4 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">

                    <span id="btnText" class="font-bold">
                        Masuk
                    </span>

                    <span id="btnLoading" class="hidden flex items-center gap-2">
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

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                        Batal / Login dengan akun lain
                    </a>
                </div>

            </div>
        </div>
    </form>

    <script>
        document.getElementById('otpForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const loading = document.getElementById('btnLoading');

            btn.disabled = true;

            btn.classList.add('opacity-75', 'cursor-wait');

            text.classList.add('hidden');

            loading.classList.remove('hidden');
        });
    </script>
@endsection
