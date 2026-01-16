<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Playfair Display', serif;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="antialiased h-screen overflow-hidden bg-gray-50">

    <div class="grid lg:grid-cols-2 h-screen">

        <div class="hidden lg:flex flex-col justify-center items-center relative overflow-hidden bg-[#0f392b]">

            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1507842217153-e21220c52221?q=80&w=1000&auto=format&fit=crop')] bg-cover bg-center opacity-20 mix-blend-overlay">
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-[#09221a] via-[#0f392b]/90 to-[#0f392b]/80"></div>

            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#c5a059] to-transparent opacity-50">
            </div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#c5a059] rounded-full blur-[150px] opacity-10"></div>

            <div class="relative z-10 text-center max-w-lg px-8 fade-in">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-white/5 border border-white/10 rounded-2xl mb-8 backdrop-blur-md shadow-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#c5a059]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <h1 class="text-5xl text-white mb-4 leading-tight">Perpustakaan <br><span
                        class="text-[#c5a059] italic"></span></h1>
                <p class="text-gray-300 text-lg font-light leading-relaxed mb-10">
                    "Buku adalah jendela dunia, dan kami memegang kuncinya. Bergabunglah untuk mengakses ribuan koleksi
                    tanpa batas."
                </p>

                <div class="flex flex-wrap justify-center gap-3">
                    <span
                        class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-sm backdrop-blur-sm">📚
                        10.000+ Koleksi</span>
                    <span
                        class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-white/80 text-sm backdrop-blur-sm">🛡️
                        Privasi Aman</span>
                </div>
            </div>

            <div class="absolute bottom-8 text-white/40 text-xs font-light tracking-widest">
                &copy; {{ date('Y') }} LIBRARY SYSTEM INC.
            </div>
        </div>

        <div class="flex flex-col h-screen overflow-y-auto bg-[#f8fafc] relative">

            <div class="lg:hidden bg-[#0f392b] p-6 text-center relative overflow-hidden">
                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
                </div>
                <h2 class="text-2xl font-bold text-white relative z-10">Perpustakaan</h2>
            </div>

            <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-[420px] fade-in" style="animation-delay: 0.2s;">

                    @if (session('success'))
                        <div
                            class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</body>

</html>
