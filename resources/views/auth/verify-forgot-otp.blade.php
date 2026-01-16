@extends('layouts.auth')

@section('title', 'Verifikasi Reset Password')

@section('content')
    <div class="mb-6 text-center">
        <h3 class="text-2xl text-[#0f392b] font-bold font-serif mb-2">Verifikasi OTP</h3>
        <p class="text-gray-500 text-sm">Kode OTP telah dikirim ke <br>
            <span class="font-bold text-gray-800">{{ session('email') }}</span>
        </p>
    </div>

    <form action="{{ route('auth.forgot.verify') }}" method="POST" class="space-y-6" id="otpForm">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2 text-center">Masukkan 6 Digit Kode</label>
            <input type="text" name="otp" required autofocus maxlength="6"
                class="w-full text-center text-3xl font-bold tracking-[0.5em] py-4 border-b-2 border-gray-300 focus:border-[#0f392b] focus:outline-none transition-colors text-[#0f392b]"
                placeholder="• • • • • •" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            @error('otp')
                <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" id="btnVerify"
            class="w-full bg-[#0f392b] hover:bg-[#09221a] text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">

            <span id="btnText">Verifikasi & Ubah Sandi</span>

            <span id="btnLoading" class="hidden flex items-center gap-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Memproses...</span>
            </span>
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-gray-600">Batal</a>
        </div>
    </form>

    {{-- SCRIPT LOADING --}}
    <script>
        document.getElementById('otpForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnVerify');
            const text = document.getElementById('btnText');
            const loading = document.getElementById('btnLoading');

            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            text.classList.add('hidden');
            loading.classList.remove('hidden');
        });
    </script>
@endsection
