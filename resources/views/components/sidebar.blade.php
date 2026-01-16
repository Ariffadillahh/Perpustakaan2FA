<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 z-[100] lg:hidden glass" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-[100] w-64 bg-[#0f392b] text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-[#c5a059]/20">

    <div class="flex items-center justify-center h-20 border-b border-[#c5a059]/20 bg-[#0a261d]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-[#c5a059] rounded flex items-center justify-center text-[#0f392b]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-lg font-bold font-serif tracking-wide text-[#c5a059]">Perpustakaan</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#c5a059] text-[#0f392b] font-bold shadow-lg' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('books.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('books.*') ? 'bg-[#c5a059] text-[#0f392b] font-bold shadow-lg' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
            </svg>
            Katalog Buku
        </a>

        <a href="{{ route('loans.index') }}"
            class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('loans.*') ? 'bg-[#c5a059] text-[#0f392b] font-bold shadow-lg' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Riwayat Peminjaman
        </a>

        @if (Auth::check() && Auth::user()->role_id === 1)
            <a href="{{ route('admin.index') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-colors
        {{ request()->routeIs('users.*')
            ? 'bg-[#c5a059] text-[#0f392b] font-bold shadow-lg'
            : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">

                <svg class="w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                Users Management
            </a>
        @endif


        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Pengaturan</p>

        <a href="{{ route('profile.dasboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('profile.*') ? 'bg-[#c5a059] text-[#0f392b] font-bold shadow-lg' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profil Saya
        </a>

    </nav>

    <div class="p-4 border-t border-[#c5a059]/20">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-300 transition-colors rounded-lg hover:bg-red-500/30 hover:text-red-400 gap-2">
                <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                </svg>

                Keluar
            </button>
        </form>
    </div>
</aside>
