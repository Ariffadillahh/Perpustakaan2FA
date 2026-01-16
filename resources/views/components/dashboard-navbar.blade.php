<header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-6 py-4">

        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden hover:text-[#0f392b]">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h2 class="text-xl font-bold text-[#0f392b] font-serif hidden sm:block">
                @yield('title')
            </h2>
        </div>

        <div class="flex items-center gap-4">

            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role->name ?? 'Staff' }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-[#c5a059] to-[#a08040] flex items-center justify-center text-[#0f392b] font-bold text-lg border border-gray-100 shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</header>
