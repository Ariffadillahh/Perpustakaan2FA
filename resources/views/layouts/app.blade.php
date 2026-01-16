<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <x-navbar />


    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#09221a] text-white pt-16 pb-8 border-t border-[#c5a059]/20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-[#c5a059] rounded-lg flex items-center justify-center text-[#0f392b]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold font-serif text-[#c5a059]">Perpustakaan</span>
                    </div>
                    <p class="text-white/50 text-sm leading-relaxed">
                        Menyediakan akses tak terbatas ke ribuan ilmu pengetahuan digital untuk membangun peradaban
                        literasi di masa depan.
                    </p>
                </div>

                <div>
                    <h4 class="text-[#c5a059] font-bold mb-6 font-serif">Navigasi</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li><a href="/" class="hover:text-[#c5a059] transition">Beranda</a></li>
                        <li><a href="#koleksi" class="hover:text-[#c5a059] transition">Koleksi Buku</a></li>
                        <li><a href="#tentang" class="hover:text-[#c5a059] transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[#c5a059] font-bold mb-6 font-serif">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#c5a059]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            support@perpustakaan.com
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-[#c5a059]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 text-center">
                <p class="text-white/30 text-[10px] uppercase tracking-[0.2em] font-bold">
                    &copy; {{ date('Y') }} Perpustakaan Digital. Dikelola dengan Integritas.
                </p>
            </div>
        </div>
    </footer>

</body>

</html>
