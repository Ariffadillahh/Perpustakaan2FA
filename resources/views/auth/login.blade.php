@extends('layouts.auth')

@section('title', 'Masuk ke Perpustakaan')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="{
        forgotModal: {{ $errors->hasAny(['email', 'password']) && old('form_type') == 'forgot' ? 'true' : 'false' }},
        loginLoading: false,
        forgotLoading: false
    }">

        <div class="mb-8">
            <h3 class="text-3xl text-[#0f392b] mb-2 font-bold font-serif">Selamat Datang</h3>
            <p class="text-gray-500 font-light">Masuk untuk mengakses ribuan koleksi buku digital.</p>
        </div>

        <form action="{{ route('auth.login.submit') }}" method="POST" class="space-y-6" @submit="loginLoading = true">
            @csrf
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1.5 ml-1">Alamat Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#0f392b] transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" name="email" value="{{ old('form_type') != 'forgot' ? old('email') : '' }}"
                        required autofocus
                        class="w-full pl-12 pr-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                        placeholder="nama@email.com">
                </div>
                @if (old('form_type') != 'forgot')
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label class="block text-gray-700 text-sm font-medium">Kata Sandi</label>
                    <button type="button" @click="forgotModal = true"
                        class="text-xs font-semibold text-[#c5a059] hover:text-[#0f392b] transition-colors focus:outline-none">
                        Lupa sandi?
                    </button>
                </div>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#0f392b] transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" required
                        class="w-full pl-12 pr-5 py-3.5 rounded-xl bg-white border border-gray-200 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 transition-all duration-300"
                        placeholder="******">
                </div>
                @if (old('form_type') != 'forgot')
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <button type="submit" :disabled="loginLoading"
                :class="loginLoading ? 'opacity-75 cursor-not-allowed' :
                    'hover:bg-[#09221a] hover:shadow-[#0f392b]/50 hover:-translate-y-0.5'"
                class="w-full bg-[#0f392b] text-white font-semibold py-4 rounded-xl shadow-lg shadow-[#0f392b]/30 transition-all duration-300 flex items-center justify-center gap-2">

                <span x-show="!loginLoading" class="flex items-center gap-2">
                    <span>Masuk Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                </span>

                <span x-show="loginLoading" class="flex items-center gap-2" x-cloak>
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

            <div class="pt-6 mt-6 border-t border-gray-100 text-center">
                <p class="text-gray-500 text-sm">
                    Belum punya akun anggota?
                    <a href="{{ route('auth.register') }}"
                        class="text-[#0f392b] font-bold hover:text-[#c5a059] transition-colors duration-200">Daftar
                        Gratis</a>
                </p>
            </div>
        </form>

        {{-- Modal Foget Password --}}
        <template x-teleport="body">
            <div x-show="forgotModal" class="fixed inset-0 z-[9999] flex items-center justify-center px-4" x-cloak>

                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="forgotModal = false"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                </div>

                <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all z-50"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                    <div class="bg-[#0f392b] p-6 text-white text-center relative">
                        <button @click="forgotModal = false"
                            class="absolute top-4 right-4 text-white/70 hover:text-white transition focus:outline-none p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <h3 class="text-xl font-bold font-serif mb-1">Reset Kata Sandi</h3>
                        <p class="text-xs text-white/80">Masukkan email terdaftar dan sandi baru Anda.</p>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('auth.forgot.submit') }}" method="POST" class="space-y-4"
                            @submit="forgotLoading = true">
                            @csrf
                            <input type="hidden" name="form_type" value="forgot">

                            <div>
                                <label
                                    class="block text-gray-700 text-[10px] font-bold mb-1 ml-1 uppercase tracking-wide">Email
                                    Terdaftar</label>
                                <input type="email" name="email"
                                    value="{{ old('form_type') == 'forgot' ? old('email') : '' }}" required
                                    class="w-full px-4 py-3 rounded-lg border {{ $errors->has('email') && old('form_type') == 'forgot' ? 'border-red-500' : 'border-gray-200' }} focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/20 outline-none text-sm transition-all"
                                    placeholder="nama@email.com">
                                @if ($errors->has('email') && old('form_type') == 'forgot')
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                                @endif
                            </div>

                            <div>
                                <label
                                    class="block text-gray-700 text-[10px] font-bold mb-1 ml-1 uppercase tracking-wide">Kata
                                    Sandi Baru</label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-3 rounded-lg border {{ $errors->has('password') && old('form_type') == 'forgot' ? 'border-red-500' : 'border-gray-200' }} focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/20 outline-none text-sm transition-all"
                                    placeholder="Minimal 6 karakter">
                                @if ($errors->has('password') && old('form_type') == 'forgot')
                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            <div>
                                <label
                                    class="block text-gray-700 text-[10px] font-bold mb-1 ml-1 uppercase tracking-wide">Konfirmasi
                                    Sandi</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/20 outline-none text-sm transition-all"
                                    placeholder="Ulangi kata sandi">
                            </div>

                            <div class="pt-2">
                                <button type="submit" :disabled="forgotLoading"
                                    :class="forgotLoading ? 'opacity-75 cursor-not-allowed' : 'hover:bg-[#b08d4b]'"
                                    class="w-full bg-[#c5a059] text-white font-bold py-3.5 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2">

                                    <span x-show="!forgotLoading" class="flex items-center gap-2">
                                        <span>Kirim Kode OTP</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </span>

                                    <span x-show="forgotLoading" class="flex items-center gap-2" x-cloak>
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span>Memproses...</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

    </div>
@endsection
