@extends('layouts.auth')

@section('title', 'Daftar Anggota')

@section('content')
    <div class="mb-10">
        <h3 class="text-3xl text-[#0f392b] mb-2 font-bold font-serif">Buat Akun</h3>
        <p class="text-gray-500 font-light">Mulai petualangan literasimu hari ini.</p>
    </div>

    <form action="{{ route('auth.register.submit') }}" method="POST" class="space-y-5" id="registerForm">
        @csrf

        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                placeholder="Cth: Budi Santoso">
            @error('name')
                <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                placeholder="nama@email.com">
            @error('email')
                <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Nomor WhatsApp</label>
            <div class="relative">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                    </svg>
                </span>

                <input type="tel" name="phone" value="{{ old('phone') }}" required
                    class="w-full pl-14 pr-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                    placeholder="08123456789">
            </div>
            @error('phone')
                <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Kata Sandi</label>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                        placeholder="******">

                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Ulangi Sandi</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                        placeholder="******">
                </div>
            </div>

            @error('password')
                <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <input type="hidden" name="role_id" value="3">

        <button type="submit" id="btnSubmit"
            class="w-full bg-[#0f392b] hover:bg-[#09221a] text-white font-semibold py-4 rounded-xl shadow-lg shadow-[#0f392b]/30 hover:shadow-[#0f392b]/50 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 mt-8">

            {{-- Konten Normal --}}
            <span class="flex items-center gap-2" id="btnText">
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </span>

            {{-- Konten Loading --}}
            <span class="hidden flex items-center gap-2" id="btnLoading">
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

        <div class="pt-6 mt-6 border-t border-gray-100 text-center">
            <p class="text-gray-500 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                    class="text-[#0f392b] font-bold hover:text-[#c5a059] transition-colors duration-200">Masuk
                    disini</a>
            </p>
        </div>
    </form>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const loading = document.getElementById('btnLoading');

            // 1. Matikan tombol
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            // 2. Ubah Tampilan
            text.classList.add('hidden');
            loading.classList.remove('hidden');
        });
    </script>
@endsection
