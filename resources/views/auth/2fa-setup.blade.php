@extends('layouts.app')

@section('title', 'Setup Google Authenticator')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-4xl w-full space-y-8">

            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-[#0f392b] font-serif">Aktifkan Autentikasi 2 Faktor</h2>
                <p class="mt-2 text-sm text-gray-600">Ikuti 3 langkah mudah di bawah ini untuk mengamankan akun Anda.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="md:flex">

                    <div class="p-8 md:w-1/2 border-r border-gray-100">
                        <div class="space-y-6">

                            <div class="flex gap-4">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-[#c5a059] text-white rounded-full flex items-center justify-center font-bold">
                                    1</div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Unduh Aplikasi</h3>
                                    <p class="text-sm text-gray-500">Unduh <strong>Google Authenticator</strong> di
                                        Android/iOS.</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-[#c5a059] text-white rounded-full flex items-center justify-center font-bold">
                                    2</div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Scan QR Code</h3>
                                    <p class="text-sm text-gray-500 mb-3">Buka aplikasi dan scan kode di bawah ini:</p>

                                    <div class="bg-white p-2 border-2 border-[#0f392b] rounded-xl inline-block">
                                        {!! $qrCode !!}
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-xs text-gray-400">Tidak bisa scan? Masukkan kode manual:</p>
                                        <code
                                            class="bg-gray-100 px-2 py-1 rounded text-[#0f392b] font-mono font-bold select-all">{{ $secret }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 md:w-1/2 bg-gray-50 flex flex-col justify-center">
                        <div class="flex gap-4 mb-6">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-[#c5a059] text-white rounded-full flex items-center justify-center font-bold">
                                3</div>
                            <div>
                                <h3 class="font-bold text-gray-800">Verifikasi Kode</h3>
                                <p class="text-sm text-gray-500">Masukkan 6 digit angka yang muncul di aplikasi Google
                                    Authenticator Anda.</p>
                            </div>
                        </div>

                        <form action="{{ route('auth.2fa.enable') }}" method="POST" x-data="{ loading: false }"
                            @submit="loading = true">
                            @csrf
                            <input type="hidden" name="secret" value="{{ $secret }}">

                            <div class="mb-6">
                                <input type="text" name="otp" placeholder="000000" maxlength="6" autofocus
                                    class="w-full text-center text-3xl font-bold tracking-[0.5em] py-4 rounded-xl border border-gray-300 focus:border-[#0f392b] focus:ring-4 focus:ring-[#0f392b]/10 outline-none transition-all text-[#0f392b]"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('otp')
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                                @enderror
                                @if (session('error'))
                                    <p class="text-red-500 text-sm mt-2 text-center">{{ session('error') }}</p>
                                @endif
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="submit" :disabled="loading" :class="{ 'opacity-75 cursor-wait': loading }"
                                    class="w-full bg-[#0f392b] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-[#09221a] transition-all flex justify-center items-center gap-2">
                                    <span x-show="!loading">Aktifkan 2FA</span>
                                    <span x-show="loading" class="flex items-center gap-2" x-cloak>
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Memverifikasi...
                                    </span>
                                </button>

                                <a href="{{ route('profile.index') }}"
                                    class="text-center text-gray-500 text-sm hover:text-gray-800 py-2">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
