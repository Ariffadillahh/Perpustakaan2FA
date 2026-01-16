@extends('layouts.app')
@section('title', 'Perpustakaan Digital - Jelajahi Ilmu')
@section('content')
    <style>
        html {
            scroll-behavior: smooth;
        }

        .book-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .book-card:hover {
            transform: translateY(-12px);
        }

        .book-card:hover .book-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .book-card:hover .book-image {
            transform: scale(1.05);
        }

        .book-image {
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-badge {
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-glow:focus-within {
            box-shadow: 0 0 0 3px rgba(15, 57, 43, 0.1);
        }
    </style>

    {{-- HERO SECTION --}}
    <div class="relative bg-[#0f392b] overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-[#c5a059]/10 skew-x-12 transform origin-top-right"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#c5a059]/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-6 py-20 lg:py-32 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                    Jelajahi Samudra <br />
                    <span class="text-[#c5a059] italic">Ilmu Pengetahuan</span>
                </h1>
                <p class="text-gray-300 text-lg mb-10 leading-relaxed max-w-xl">
                    Akses ribuan koleksi buku digital berkualitas tinggi kapan saja dan di
                    mana saja. Bergabunglah dengan komunitas literasi terbesar kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('auth.register') }}"
                        class="px-8 py-4 bg-[#c5a059] hover:bg-white text-[#0f392b] font-bold rounded-xl transition-all duration-300 shadow-lg shadow-[#c5a059]/20 text-center">
                        Mulai Membaca Sekarang
                    </a>
                    <a href="#koleksi"
                        class="px-8 py-4 border border-white/20 hover:bg-white/10 text-white font-medium rounded-xl transition-all duration-300 backdrop-blur-sm text-center">
                        Lihat Katalog
                    </a>
                </div>

                <div class="mt-16 flex items-center gap-8 border-t border-white/10 pt-8">
                    <div>
                        <p class="text-3xl font-bold text-white">10k+</p>
                        <p class="text-white/60 text-sm">Buku Digital</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div>
                        <p class="text-3xl font-bold text-white">5k+</p>
                        <p class="text-white/60 text-sm">Anggota Aktif</p>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- SECTION: KOLEKSI BUKU --}}
    <div class="py-24 bg-gradient-to-b from-gray-50 to-white" id="koleksi">
        <div class="container mx-auto px-6">
            {{-- Header Section --}}
            <div class="text-center mb-5">
                <div class="inline-block">
                    <span class="text-[#c5a059] text-sm font-bold uppercase tracking-widest mb-2 block">Koleksi Kami</span>
                    <h2 class="text-5xl font-bold text-[#0f392b] font-serif mb-4">
                        Temukan Buku Favorit
                    </h2>
                    <div class="w-24 h-1 bg-[#c5a059] mx-auto rounded-full"></div>
                </div>
                <p class="text-gray-600 mt-6 max-w-2xl mx-auto text-lg">
                    Menampilkan {{ $books->total() }} koleksi terpilih dari berbagai kategori
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="max-w-2xl mx-auto mb-5">
                @if (request('search'))
                    <div class="text-center">
                        <span class="text-gray-600">Hasil pencarian untuk: </span>
                        <span class="font-bold text-[#0f392b]">"{{ request('search') }}"</span>
                        <a href="{{ route('landing') }}#koleksi"
                            class="ml-3 text-sm text-red-500 hover:text-red-700 font-medium hover:underline transition">
                            ✕ Hapus Pencarian
                        </a>
                    </div>
                @endif
            </div>

            {{-- GRID BUKU --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($books as $book)
                    <div
                        class="book-card group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border border-gray-100">
                        {{-- Badge Kategori --}}
                        <span
                            class="category-badge absolute top-4 left-4 z-20 bg-[#0f392b] text-[#c5a059] text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-xl">
                            {{ $book->category->name ?? 'Umum' }}
                        </span>

                        {{-- Book Cover --}}
                        <div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                            @if ($book->thumbnail)
                                <img src="{{ asset('storage/' . $book->thumbnail) }}"
                                    class="book-image w-full h-full object-cover" alt="{{ $book->name }}" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Overlay --}}
                            <div
                                class="book-overlay absolute inset-0 bg-gradient-to-t from-[#0f392b] via-[#0f392b]/95 to-[#0f392b]/80 backdrop-blur-sm flex flex-col items-center justify-end p-6 opacity-0 translate-y-4 transition-all duration-500 z-10">
                                <p class="text-white/90 text-center text-sm mb-6 line-clamp-4 leading-relaxed">
                                    {{ Str::limit($book->description ?? 'Deskripsi tidak tersedia untuk buku ini.', 120) }}
                                </p>
                                <a href="{{ route('books.show', $book->id) }}"
                                    class="w-full py-3.5 bg-[#c5a059] text-[#0f392b] text-center rounded-xl font-bold hover:bg-white hover:scale-105 transition-all duration-300 shadow-2xl">
                                    📖 Lihat Detail & Pinjam
                                </a>
                            </div>
                        </div>

                        {{-- Book Info --}}
                        <div class="p-6">
                            <h3
                                class="font-bold text-gray-900 text-xl mb-2 group-hover:text-[#0f392b] transition-colors line-clamp-2 leading-snug min-h-[3.5rem]">
                                {{ $book->name }}
                            </h3>

                            <div class="flex items-center gap-3 mt-3 pt-3 border-t border-gray-100">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-sm text-gray-600 font-medium line-clamp-1">
                                    {{ $book->author }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Buku Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6">
                            Maaf, tidak ada buku yang sesuai dengan pencarian Anda.
                        </p>
                        <a href="{{ route('landing') }}#koleksi"
                            class="inline-block px-8 py-3 bg-[#0f392b] text-white rounded-xl font-medium hover:bg-[#c5a059] hover:text-[#0f392b] transition-all">
                            Lihat Semua Buku
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-5">
                {{ $books->appends(['search' => request('search')])->fragment('koleksi')->links('pagination.custom') }}
            </div>
        </div>
    </div>

    {{-- SECTION: TENTANG KAMI --}}
    <div class="py-32 bg-[#0f392b] relative overflow-hidden" id="tentang">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#c5a059]/20 rounded-full blur-3xl"></div>
                    <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1000&q=80"
                        class="rounded-3xl shadow-2xl relative z-10 border border-white/10 grayscale hover:grayscale-0 transition-all duration-700"
                        alt="Tentang Kami" />
                </div>
                <div class="text-white">
                    <h2 class="text-4xl font-bold mb-8 font-serif text-[#c5a059]">
                        Kultur Membaca di <br />
                        Era Digital
                    </h2>
                    <p class="text-gray-300 text-lg mb-10 leading-relaxed">
                        Kami hadir untuk mendefinisikan ulang cara Anda mengakses pengetahuan.
                        Dengan ribuan koleksi yang terintegrasi, Perpustakaan Digital kami
                        memastikan literasi tidak lagi terbatas oleh jarak dan waktu.
                    </p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-4 text-gray-300">
                            <span
                                class="w-6 h-6 rounded-full bg-[#c5a059]/20 flex items-center justify-center text-[#c5a059]">✓</span>
                            Koleksi Terkurasi oleh Ahli Literasi
                        </li>
                        <li class="flex items-center gap-4 text-gray-300">
                            <span
                                class="w-6 h-6 rounded-full bg-[#c5a059]/20 flex items-center justify-center text-[#c5a059]">✓</span>
                            Akses 24/7 dari Seluruh Dunia
                        </li>
                    </ul>
                    <button
                        class="bg-white/5 border border-white/10 px-8 py-4 rounded-xl hover:bg-[#c5a059] hover:text-[#0f392b] transition-all font-bold">
                        Pelajari Visi Kami
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
