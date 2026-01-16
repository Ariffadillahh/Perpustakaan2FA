<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<nav class="bg-[#0f392b]/95 text-white sticky top-0 z-[50] shadow-xl border-b border-[#c5a059]/30 backdrop-blur-md"
    x-data="{ mobileOpen: false, profileOpen: false, searchOpen: false }">

    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center h-20">

            <a href="/" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 bg-[#c5a059] rounded-lg flex items-center justify-center text-[#0f392b] shadow-lg group-hover:rotate-12 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-bold font-serif tracking-wide text-[#c5a059]">Perpustakaan</span>
            </a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="/" class="text-white/80 hover:text-[#c5a059] text-sm font-medium transition">Beranda</a>
                <a href="#koleksi" class="text-white/80 hover:text-[#c5a059] text-sm font-medium transition">Koleksi
                    Buku</a>
                <a href="#tentang" class="text-white/80 hover:text-[#c5a059] text-sm font-medium transition">Tentang
                    Kami</a>

                <button @click="searchOpen = true" class="p-2 rounded-full hover:bg-white/10 transition group">
                    <svg class="w-5 h-5 text-white/80 group-hover:text-[#c5a059]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <div class="hidden md:flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-white hover:text-[#c5a059] font-medium transition-colors">Masuk</a>
                    <a href="{{ route('auth.register') }}"
                        class="bg-[#c5a059] text-[#0f392b] px-5 py-2.5 rounded-full font-bold text-sm hover:bg-white hover:text-[#0f392b] transition-all duration-300 shadow-lg shadow-[#c5a059]/20">
                        Daftar Gratis
                    </a>
                @else
                    <div class="relative" @click.outside="profileOpen = false">
                        <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-bold text-white group-hover:text-[#c5a059] transition-colors">
                                    {{ Auth::user()->name }}</p>
                                <p class="text-xs text-white/60">
                                    @if (Auth::user()->role_id == 1)
                                        Admin
                                    @elseif(Auth::user()->role_id == 2)
                                        Petugas
                                    @else
                                        Anggota
                                    @endif
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-[#c5a059] to-[#a08040] flex items-center justify-center text-[#0f392b] font-bold text-lg border-2 border-[#0f392b] ring-2 ring-[#c5a059]/50">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 text-white/60 group-hover:text-[#c5a059] transition-colors"
                                :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-2xl py-2 border border-gray-100 overflow-hidden text-gray-800"
                            x-cloak>

                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-sm text-gray-500">Login sebagai</p>
                                <p class="font-bold text-[#0f392b] truncate">{{ Auth::user()->email }}</p>
                            </div>

                            {{-- LOGIKA ROLE: 1 & 2 (Admin/Petugas), 3 (Anggota) --}}

                            @if (Auth::user()->role_id == 3)
                                {{-- MENU ANGGOTA --}}
                                <a href="{{ route('loans.index') }}"
                                    class="flex items-center px-4 py-3 hover:bg-[#f0fdf4] text-gray-700 hover:text-[#0f392b] transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Peminjaman Saya
                                </a>
                                <a href="{{ route('profile.index') }}"
                                    class="flex items-center px-4 py-3 hover:bg-[#f0fdf4] text-gray-700 hover:text-[#0f392b] transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                            @else
                                {{-- MENU ADMIN / PETUGAS --}}
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center px-4 py-3 hover:bg-[#f0fdf4] text-gray-700 hover:text-[#0f392b] transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7m-9 2v6m4-6v6m5 0h-14" />
                                    </svg>
                                    Dashboard Admin
                                </a>
                            @endif

                            <div class="border-t border-gray-100 mt-1">
                                <form action="{{ route('logout') }}" method="POST" x-data="{ loading: false }"
                                    @submit="loading = true">
                                    @csrf
                                    <button type="submit" :disabled="loading"
                                        :class="{ 'opacity-75 cursor-wait': loading }"
                                        class="w-full text-left flex items-center px-4 py-3 hover:bg-red-50 text-red-600 transition-colors">
                                        <div x-show="!loading" class="flex items-center gap-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                            </svg>
                                            Keluar
                                        </div>
                                        <div x-show="loading" class="flex items-center" x-cloak>
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-red-600"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Memproses...
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <div class="md:hidden flex items-center gap-3">
                <button @click="searchOpen = true"><svg class="w-6 h-6 text-white" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg></button>
                @auth <button @click="profileOpen = !profileOpen" class="relative">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-[#c5a059] to-[#a08040] flex items-center justify-center text-[#0f392b] font-bold text-sm border-2 border-white/20">
                            {{ substr(Auth::user()->name, 0, 1) }}</div>
                </button> @endauth
                <button @click="mobileOpen = !mobileOpen"><svg class="w-7 h-7" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg></button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" x-cloak class="md:hidden bg-[#0a261d] px-6 py-4 space-y-3">
        <a href="/" class="block text-white/80 hover:text-[#c5a059] py-2">Beranda</a>
        <a href="#koleksi" class="block text-white/80 hover:text-[#c5a059] py-2">Koleksi Buku</a>
        <a href="#tentang" class="block text-white/80 hover:text-[#c5a059] py-2">Tentang Kami</a>
        @guest
            <div class="pt-3 border-t border-white/10 space-y-2">
                <a href="{{ route('login') }}" class="block text-white hover:text-[#c5a059] py-2">Masuk</a>
                <a href="{{ route('auth.register') }}"
                    class="block bg-[#c5a059] text-[#0f392b] px-4 py-2.5 rounded-full font-bold text-sm text-center hover:bg-white transition-all">Daftar
                    Gratis</a>
            </div>
        @endguest
    </div>

    @auth
        <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="profileOpen = false"
            class="md:hidden bg-[#0a261d] border-t border-white/10">

            <div class="px-6 py-4">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-[#c5a059] to-[#a08040] flex items-center justify-center text-[#0f392b] font-bold text-lg border-2 border-white/20">
                        {{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/60">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    {{-- LOGIKA ROLE MOBILE --}}
                    @if (Auth::user()->role_id == 3)
                        <a href="{{ route('loans.index') }}"
                            class="flex items-center gap-3 text-white/80 hover:text-[#c5a059] hover:bg-white/5 px-3 py-3 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            Peminjaman Saya
                        </a>
                        <a href="{{ route('profile.index') }}"
                            class="flex items-center gap-3 text-white/80 hover:text-[#c5a059] hover:bg-white/5 px-3 py-3 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 text-white/80 hover:text-[#c5a059] hover:bg-white/5 px-3 py-3 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7m-9 2v6m4-6v6m5 0h-14" />
                            </svg>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" x-data="{ loading: false }"
                        @submit="loading = true" class="pt-2 border-t border-white/10 mt-2">
                        @csrf
                        <button type="submit" :disabled="loading" :class="{ 'opacity-75 cursor-wait': loading }"
                            class="w-full flex items-center gap-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 px-3 py-3 rounded-lg transition-colors">
                            <div x-show="!loading" class="flex items-center gap-3"><svg class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                </svg>Keluar</div>
                            <div x-show="loading" class="flex items-center gap-3" x-cloak><svg
                                    class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>Memproses...</div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <template x-teleport="body">
        <div x-show="searchOpen" x-transition.opacity x-cloak
            class="fixed inset-0 z-[9999] bg-black/70 backdrop-blur-sm flex items-center justify-center min-h-screen px-4"
            @keydown.escape.window="searchOpen = false">
            <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl" @click.outside="searchOpen = false"
                x-transition.scale>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-[#0f392b]">Cari Buku</h2>
                    <button @click="searchOpen = false"
                        class="text-gray-400 hover:text-red-500 text-xl leading-none">&times;</button>
                </div>
                <form action="{{ route('landing') }}#koleksi" method="GET">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Masukkan judul buku..." autofocus
                            class="w-full rounded-xl border border-gray-300 pl-10 pr-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#0f392b]/50" />
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><svg class="w-4 h-4"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg></span>
                    </div>
                    <button type="submit"
                        class="mt-4 w-full bg-[#0f392b] text-white py-3 rounded-xl font-semibold hover:bg-[#145c44] transition">Cari</button>
                </form>
            </div>
        </div>
    </template>
</nav>
