@extends('layouts.app')

@section('title', 'Detail Literatur - ' . $book->name)

@section('content')
    <div class="w-full bg-[#f8fafc] min-h-screen pb-12">
        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-[250px] md:h-[300px] bg-[#0f392b] clip-path-slant z-0"></div>

        <div class="container mx-auto px-4 md:px-6 lg:px-12 relative pt-6 md:pt-8 z-10">

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm"
                    role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Glassmorphism Breadcrumb --}}
            <nav class="flex mb-6 bg-white/10 backdrop-blur-md border border-white/20 w-fit px-4 py-2 rounded-xl shadow-xl">
                <ol class="flex items-center space-x-2 text-xs">
                    <li>
                        <a href="{{ route('landing') }}#koleksi"
                            class="text-white/70 hover:text-[#c5a059] transition-all flex items-center">
                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Katalog
                        </a>
                    </li>
                    <li class="text-[#c5a059] font-bold flex items-center">
                        <svg class="w-3 h-3 mx-1.5 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z">
                            </path>
                        </svg>
                        Detail Buku
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                {{-- KOLOM KIRI & TENGAH: COVER + CONTENT --}}
                <div class="lg:col-span-8">
                    <div
                        class="bg-white p-6 md:p-8 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 relative overflow-hidden">

                        {{-- Decorative Icon --}}
                        <svg class="absolute -right-8 -top-8 w-24 h-24 md:w-32 md:h-32 text-gray-50/50 -rotate-12 pointer-events-none"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>

                        <div class="flex flex-col md:flex-row gap-6 md:gap-8">
                            {{-- COVER IMAGE --}}
                            <div class="flex-shrink-0 mx-auto md:mx-0 w-40 md:w-56">
                                <div class="relative group">
                                    <div
                                        class="absolute -inset-2 bg-gradient-to-tr from-[#c5a059] to-[#0f392b] rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition duration-700">
                                    </div>
                                    <div
                                        class="relative bg-white rounded-2xl overflow-hidden shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] border-4 border-white aspect-[3/4.2]">
                                        @if ($book->thumbnail)
                                            <img src="{{ asset('storage/' . $book->thumbnail) }}"
                                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                                alt="{{ $book->name }}">
                                        @else
                                            <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                                                <svg class="w-16 h-16 md:w-20 md:h-20 text-slate-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- CONTENT --}}
                            <div class="flex-1 text-center md:text-left">
                                <span
                                    class="bg-[#c5a059]/10 text-[#a08040] text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-[0.2em] mb-3 md:mb-4 inline-block">
                                    {{ $book->category->name ?? 'Literatur' }}
                                </span>

                                <h1
                                    class="text-2xl md:text-3xl font-bold text-[#0f392b] font-serif mb-2 leading-tight tracking-tight">
                                    {{ $book->name }}
                                </h1>
                                <p class="text-sm md:text-base text-gray-400 font-light italic mb-6">Dibuat oleh <span
                                        class="text-[#c5a059] font-semibold">{{ $book->author }}</span></p>

                                <div class="grid grid-cols-2 gap-3 md:gap-4 mb-6">
                                    <div
                                        class="p-3 md:p-4 bg-[#f8fafc] rounded-2xl border border-gray-100 group hover:border-[#c5a059]/30 transition-all text-center md:text-left">
                                        <p
                                            class="text-[8px] md:text-[9px] uppercase font-black text-gray-400 tracking-[0.15em] mb-1">
                                            Stok Digital
                                        </p>
                                        <p class="text-xl md:text-2xl font-black text-[#0f392b]">{{ $book->stock }} <span
                                                class="text-[10px] md:text-xs font-normal text-gray-400">Unit</span></p>
                                    </div>
                                    <div
                                        class="p-3 md:p-4 bg-[#f8fafc] rounded-2xl border border-gray-100 group hover:border-[#c5a059]/30 transition-all text-center md:text-left">
                                        <p
                                            class="text-[8px] md:text-[9px] uppercase font-black text-gray-400 tracking-[0.15em] mb-1">
                                            Tahun Rilis
                                        </p>
                                        <p class="text-xl md:text-2xl font-black text-[#0f392b]">
                                            {{ $book->release_year ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mb-6 text-left">
                                    <h4
                                        class="text-[#0f392b] text-[10px] font-black mb-3 uppercase tracking-[0.2em] flex items-center gap-3">
                                        Sinopsis Literatur <span class="flex-1 h-px bg-gray-100"></span>
                                    </h4>
                                    <p class="text-gray-500 leading-relaxed text-sm font-light text-justify">
                                        {{ $book->description ?? 'Analisis literatur mendalam untuk buku ini belum tersedia di basis data kami.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- MODERN FORM --}}
                        <form id="loanForm" action="{{ route('loans.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" id="return_date" name="return_date" required>

                            <div class="bg-gradient-to-br from-[#0f392b] to-[#0a261d] p-1 rounded-2xl shadow-2xl mt-8">
                                <div
                                    class="bg-[#0f392b] rounded-xl p-4 md:p-6 border border-white/5 relative overflow-hidden">

                                    {{-- Background Pattern --}}
                                    <div
                                        class="absolute top-0 right-0 w-32 h-32 bg-[#c5a059] blur-[80px] opacity-10 rounded-full pointer-events-none">
                                    </div>

                                    <div class="flex justify-between items-center mb-6 text-white relative z-10">
                                        <div class="text-left">
                                            <p
                                                class="text-[8px] md:text-[9px] text-[#c5a059] font-bold uppercase tracking-widest mb-1">
                                                Tanggal Pinjam</p>
                                            <p class="text-base md:text-lg font-serif font-bold" id="display_start_date">-
                                            </p>
                                        </div>

                                        <div class="flex flex-col items-center px-2 md:px-4 opacity-50">
                                            <span class="text-[8px] md:text-[9px] text-white/50 mb-1">7 Hari</span>
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </div>

                                        <div class="text-right">
                                            <p
                                                class="text-[8px] md:text-[9px] text-red-400 font-bold uppercase tracking-widest mb-1">
                                                Wajib Kembali</p>
                                            <p class="text-base md:text-lg font-serif font-bold text-red-50"
                                                id="display_end_date">-</p>
                                        </div>
                                    </div>

                                    <div class="w-full border-t-2 border-dashed border-white/10 mb-6 relative">
                                        <div class="absolute -left-8 -top-3 w-6 h-6 bg-[#f8fafc] rounded-full"></div>
                                        <div class="absolute -right-8 -top-3 w-6 h-6 bg-[#f8fafc] rounded-full"></div>
                                    </div>

                                    <div class="mt-8">
                                        @php $totalDendaBorrowed = $loans->where('status', 'borrowed')->sum('current_fine'); @endphp @if ($totalDendaBorrowed > 0)
                                            <div
                                                class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex gap-3 items-start">
                                                <div class="bg-red-100 p-2 rounded-full text-red-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>
                                                <div class="text-left">
                                                    <h4 class="text-red-700 font-bold text-sm mb-1">
                                                        Tunggakan Denda Terdeteksi
                                                    </h4>
                                                    <p class="text-xs text-red-600 leading-relaxed mb-2">
                                                        Anda memiliki total denda sebesar
                                                        <span class="font-bold">Rp
                                                            {{ number_format($totalDendaBorrowed, 0, ',', '.') }}</span>
                                                        yang belum dilunasi.
                                                    </p>
                                                    <p class="text-[10px] text-red-500 italic">
                                                        Silakan lunasi pembayaran di perpustakaan ("Bayar oi").
                                                    </p>
                                                </div>
                                            </div>

                                            <button disabled
                                                class="w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-xl cursor-not-allowed shadow-none flex items-center justify-center gap-2 uppercase tracking-widest text-xs border border-gray-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Akses Peminjaman Dikunci
                                            </button>
                                        @else
                                            <button type="submit" id="loanBtn"
                                                @if ($book->stock <= 0) disabled @endif
                                                class="group w-full relative
                    overflow-hidden rounded-xl py-3 md:py-4 px-6 transition-all
                    shadow-[0_10px_30px_rgba(197,160,89,0.2)]
                    disabled:cursor-not-allowed disabled:shadow-none
                    bg-[#c5a059]">
                                                @if ($book->stock > 0)
                                                    <div
                                                        class="absolute inset-0 bg-gradient-to-r from-[#c5a059] to-[#e0c070] transition-all group-hover:scale-105">
                                                    </div>

                                                    <div id="btnContent"
                                                        class="relative flex items-center justify-center gap-3 text-[#0f392b] font-black text-[10px] md:text-xs uppercase tracking-[0.25em]">
                                                        <span>Konfirmasi Peminjaman</span>
                                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                        </svg>
                                                    </div>

                                                    {{-- Loading State --}}
                                                    <div id="btnLoading"
                                                        class="hidden relative flex items-center justify-center gap-3 text-[#0f392b] font-black text-[10px] md:text-xs uppercase tracking-[0.25em]">
                                                        <svg class="animate-spin h-4 w-4 text-[#0f392b]"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                        <span>Memproses...</span>
                                                    </div>
                                                @else
                                                    {{-- STOK HABIS --}}
                                                    <div class="absolute inset-0 bg-slate-700"></div>
                                                    <div
                                                        class="relative flex items-center justify-center gap-2 text-slate-400 font-bold text-xs uppercase tracking-widest">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                        Stok Habis
                                                    </div>
                                                @endif
                                            </button>
                                        @endif
                                    </div>

                                    @if ($book->stock > 0)
                                        <p class="text-center text-[8px] md:text-[9px] text-white/30 mt-3 font-light px-4">
                                            Dengan klik tombol di atas, Anda menyetujui sanksi keterlambatan.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- KOLOM KANAN: REMINDER --}}
                <div class="lg:col-span-4 space-y-6">
                    <div
                        class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border border-gray-100 relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-[#0f392b]/5 rounded-bl-[80px] transition-all group-hover:w-full group-hover:h-full group-hover:rounded-none duration-700">
                        </div>

                        <div class="relative z-10">
                            <div
                                class="w-10 h-10 bg-[#0f392b] rounded-xl flex items-center justify-center text-[#c5a059] mb-6 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h5 class="text-[#0f392b] font-black text-[10px] uppercase tracking-[0.15em] mb-6">Informasi &
                                Sanksi
                            </h5>

                            <div class="space-y-6">
                                <div>
                                    <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-1.5">
                                        Maksimal
                                        Durasi</p>
                                    <p class="text-2xl font-black text-[#0f392b]">7 Hari Kalender</p>
                                </div>

                                <div>
                                    <p class="text-[9px] text-red-400 font-black uppercase tracking-widest mb-1.5">Denda
                                        Keterlambatan</p>
                                    <p class="text-2xl font-black text-red-500">Rp 1.000 <span
                                            class="text-xs font-normal text-gray-400">/ hari</span></p>
                                </div>
                            </div>

                            <div class="mt-8 p-5 bg-red-50 rounded-xl border border-red-100">
                                <p class="text-[10px] leading-relaxed text-red-700 font-medium italic">
                                    "Kepercayaan adalah kunci. Mohon kembalikan buku tepat waktu untuk menghindari
                                    penangguhan akun otomatis."
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Account Status --}}
                    <div
                        class="bg-[#0f392b] rounded-2xl p-6 shadow-2xl flex items-center gap-4 border border-white/10 relative overflow-hidden">
                        <div class="relative z-10 flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-[#c5a059] flex items-center justify-center text-[#0f392b] font-black text-lg shadow-inner">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] text-[#c5a059] font-black uppercase tracking-widest">Status: Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .clip-path-slant {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        @media (min-width: 768px) {
            .clip-path-slant {
                clip-path: polygon(0 0, 100% 0, 100% 70%, 0 100%);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. LOGIKA TANGGAL ---
            const dateInput = document.getElementById('return_date');
            const displayStart = document.getElementById('display_start_date');
            const displayEnd = document.getElementById('display_end_date');

            const today = new Date();
            const durationDays = 7;

            const deadlineDate = new Date(today);
            deadlineDate.setDate(today.getDate() + durationDays);

            // Format DB: YYYY-MM-DD
            // Perhatikan timezone offset agar tanggal tidak mundur 1 hari
            const formatForDB = (date) => {
                const offset = date.getTimezoneOffset();
                const localDate = new Date(date.getTime() - (offset * 60 * 1000));
                return localDate.toISOString().split('T')[0];
            };

            const formatForDisplay = (date) => {
                return new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).format(date);
            };

            if (dateInput) dateInput.value = formatForDB(deadlineDate);
            if (displayStart) displayStart.innerText = formatForDisplay(today);
            if (displayEnd) displayEnd.innerText = formatForDisplay(deadlineDate);

            // --- 2. LOGIKA LOADING BUTTON ---
            const loanForm = document.getElementById('loanForm');
            const loanBtn = document.getElementById('loanBtn');
            const btnContent = document.getElementById('btnContent');
            const btnLoading = document.getElementById('btnLoading');

            if (loanForm) {
                loanForm.addEventListener('submit', function() {
                    // Disable button
                    loanBtn.disabled = true;
                    loanBtn.classList.add('cursor-not-allowed', 'opacity-80');

                    // Toggle visibility
                    btnContent.classList.add('hidden');
                    btnLoading.classList.remove('hidden');
                    btnLoading.classList.add('flex');
                });
            }
        });
    </script>
@endsection
