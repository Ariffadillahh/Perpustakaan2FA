@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <div class="container mx-auto px-6 py-10">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-[#0f392b] font-serif">Pengaturan Akun</h1>
            <p class="text-gray-500">Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- CARD 1: EDIT PROFIL --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-12 h-12 bg-[#0f392b]/10 rounded-full flex items-center justify-center text-[#0f392b]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Informasi Profil</h2>
                            <p class="text-sm text-gray-500">Perbarui nama dan kontak Anda.</p>
                        </div>
                    </div>

                    {{-- FORM UPDATE PROFILE (Dengan Alpine x-data loading) --}}
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5" x-data="{ loading: false }"
                        @submit="loading = true">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition-all">
                                @error('name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $user->phone_number) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition-all">
                                @error('phone_number')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition-all">
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" :disabled="loading" :class="{ 'opacity-75 cursor-wait': loading }"
                                class="bg-[#0f392b] text-white px-6 py-3 rounded-xl font-medium hover:bg-[#09221a] transition-colors shadow-lg shadow-[#0f392b]/20 flex items-center gap-2">
                                <span x-show="!loading">Simpan Perubahan</span>
                                <span x-show="loading" class="flex items-center gap-2" x-cloak>
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- CARD 2: GANTI PASSWORD --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                        <div class="w-12 h-12 bg-[#c5a059]/10 rounded-full flex items-center justify-center text-[#c5a059]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Ganti Kata Sandi</h2>
                            <p class="text-sm text-gray-500">Pastikan akun Anda tetap aman.</p>
                        </div>
                    </div>

                    {{-- FORM GANTI PASSWORD (Dengan Alpine x-data loading) --}}
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-5" x-data="{ loading: false }"
                        @submit="loading = true">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/10 outline-none transition-all">
                            @error('current_password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/10 outline-none transition-all">
                                @error('password')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ulangi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#c5a059] focus:ring-2 focus:ring-[#c5a059]/10 outline-none transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" :disabled="loading" :class="{ 'opacity-75 cursor-wait': loading }"
                                class="bg-white border border-[#c5a059] text-[#c5a059] px-6 py-3 rounded-xl font-medium hover:bg-[#c5a059] hover:text-white transition-colors flex items-center gap-2">
                                <span x-show="!loading">Update Password</span>
                                <span x-show="loading" class="flex items-center gap-2" x-cloak>
                                    <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-8">

                {{-- CARD 3: 2FA --}}
                <div
                    class="bg-gradient-to-br from-[#0f392b] to-[#09221a] rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#c5a059]/10 rounded-full blur-2xl -mr-10 -mt-10">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-[#c5a059]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>

                        <h2 class="text-xl font-bold mb-2">Autentikasi 2 Faktor</h2>
                        <p class="text-white/70 text-sm mb-6 leading-relaxed">Tambahkan lapisan keamanan ekstra. Kami akan
                            meminta kode dari Google Authenticator setiap kali Anda login.</p>

                        @if ($user->two_factor_enabled)
                            <div
                                class="bg-green-500/20 border border-green-500/50 rounded-lg p-3 mb-6 flex items-center gap-3">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-green-300 font-bold text-sm tracking-wide">AKTIF & TERLINDUNGI</span>
                            </div>

                            {{-- FORM DISABLE 2FA (Dengan Alpine x-data loading) --}}
                            <form action="{{ route('auth.2fa.disable') }}" method="POST" class="mt-4"
                                x-data="{ loading: false }" @submit="loading = true">
                                @csrf
                                <div class="mb-3">
                                    <label class="text-xs text-white/50 mb-1 block">Konfirmasi Password untuk
                                        Menonaktifkan:</label>
                                    <input type="password" name="current_password" required placeholder="******"
                                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/30 text-sm focus:outline-none focus:border-[#c5a059]">
                                    @error('current_password')
                                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" :disabled="loading"
                                    :class="{ 'opacity-75 cursor-wait': loading }"
                                    class="w-full py-3 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 font-medium transition-colors text-sm flex items-center justify-center gap-2">
                                    <span x-show="!loading">Nonaktifkan 2FA</span>
                                    <span x-show="loading" class="flex items-center gap-2" x-cloak>
                                        <svg class="animate-spin h-4 w-4 text-red-300" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            </form>
                        @else
                            <div
                                class="bg-yellow-500/20 border border-yellow-500/50 rounded-lg p-3 mb-6 flex items-center gap-3">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                <span class="text-yellow-300 font-bold text-sm tracking-wide">BELUM AKTIF</span>
                            </div>

                            <a href="{{ route('profile-setup.dasboard') }}"
                                class="block w-full py-3 rounded-xl bg-[#c5a059] hover:bg-[#b08d4b] text-[#0f392b] font-bold text-center transition-colors shadow-lg">
                                Aktifkan Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-3">Tips Keamanan</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Gunakan password yang kuat (huruf, angka, simbol).
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Jangan bagikan kode OTP/2FA kepada siapapun.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-5 right-5 bg-[#0f392b] text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 animate-bounce-in">
            <svg class="w-6 h-6 text-[#c5a059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-sm">Berhasil!</h4>
                <p class="text-xs text-white/80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

@endsection
