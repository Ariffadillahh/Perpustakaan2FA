@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-5 md:my-10 p-5">

        {{-- HEADER USER PROFILE --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-6">
            <div
                class="w-24 h-24 rounded-full bg-gradient-to-br from-[#c5a059] to-[#0f392b] flex items-center justify-center text-white text-3xl font-bold border-4 border-white shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="text-center md:text-left flex-grow">
                <h1 class="text-2xl font-bold text-gray-800 font-serif">{{ Auth::user()->name }}</h1>
                <p class="text-gray-500">{{ Auth::user()->email }}</p>
                <div class="mt-2 flex flex-wrap justify-center md:justify-start gap-2">
                    <span
                        class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                        {{ Auth::user()->role_id == 3 ? 'Anggota' : 'Petugas' }}
                    </span>
                </div>
            </div>

            {{-- TOTAL DENDA --}}
            @php
                $totalDendaBorrowed = $loans->where('status', 'borrowed')->sum('current_fine');
            @endphp

            <div class="bg-red-50 border border-red-100 p-5 rounded-2xl text-center min-w-[220px]">
                <p class="text-[10px] text-red-400 font-bold uppercase tracking-widest mb-1">
                    Total Denda Anda
                </p>

                <p class="text-2xl font-black text-red-600">
                    Rp {{ number_format($totalDendaBorrowed, 0, ',', '.') }}
                </p>

                @if ($totalDendaBorrowed > 0)
                    <p class="text-[9px] text-red-500 mt-2 leading-tight">
                        * Segera lunasi denda untuk dapat meminjam kembali.
                    </p>
                @endif
            </div>

        </div>

        {{-- TABEL RIWAYAT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-4">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="font-bold text-gray-800 font-serif italic">Riwayat Peminjaman Saya</h3>
                    <p class="text-xs text-gray-500">Daftar buku yang sedang atau pernah Anda pinjam.</p>
                </div>
            </div>

            {{-- WRAPPER TABLE --}}
            <div class="overflow-x-auto">
                {{-- Tambahkan whitespace-nowrap agar teks tidak turun baris --}}
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Buku</th>
                            <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                            <th class="px-6 py-4 text-center">Batas Kembali</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-gray-50/80 transition">
                                {{-- KOLOM BUKU --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-14 bg-gray-100 rounded shadow-sm overflow-hidden flex-shrink-0 border border-gray-200">
                                            @if ($loan->book->thumbnail)
                                                <img src="{{ asset('storage/' . $loan->book->thumbnail) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            {{-- Tambahkan truncate agar judul panjang tidak merusak layout --}}
                                            <p class="font-bold text-gray-800 leading-tight max-w-[200px] truncate"
                                                title="{{ $loan->book->name }}">
                                                {{ $loan->book->name }}
                                            </p>
                                            <p class="text-[10px] text-gray-400">{{ $loan->book->author }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM TGL PINJAM --}}
                                <td class="px-6 py-4 text-center text-gray-500 font-medium">
                                    {{ $loan->loan_date->format('d M Y') }}
                                </td>

                                {{-- KOLOM BATAS KEMBALI --}}
                                <td class="px-6 py-4 text-center text-gray-500 font-medium">
                                    {{ $loan->return_date->format('d M Y') }}
                                </td>

                                {{-- KOLOM STATUS --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($loan->status == 'borrowed')
                                        <span
                                            class="bg-blue-50 text-blue-600 border border-blue-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">
                                            Masih Dipinjam
                                        </span>
                                    @else
                                        <span
                                            class="bg-green-50 text-green-600 border border-green-100 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">
                                            Sudah Kembali
                                        </span>
                                    @endif
                                </td>

                                {{-- KOLOM DENDA (Manual Calculation for User View) --}}
                                <td class="px-6 py-4 text-right">
                                    @php
                                        // LOGIKA HITUNG MANUAL (Sama seperti Dashboard)
                                        $tglPinjam = \Carbon\Carbon::parse($loan->loan_date)->setTimezone(
                                            'Asia/Jakarta',
                                        );
                                        $deadline = $tglPinjam->copy()->addDays(7)->endOfDay();
                                        $sekarang = \Carbon\Carbon::now('Asia/Jakarta');

                                        $denda = 0;
                                        $telatHari = 0;

                                        if ($loan->status == 'borrowed') {
                                            if ($sekarang->gt($deadline)) {
                                                $diff = $sekarang->floatDiffInDays($deadline);
                                                $telatHari = ceil(abs($diff));
                                                $denda = $telatHari * 1000;
                                            }
                                        } elseif ($loan->status == 'returned') {
                                            $denda = $loan->fine_amount ?? 0;
                                        }
                                    @endphp

                                    @if ($denda > 0)
                                        <div class="flex flex-col items-end gap-1">
                                            <span
                                                class="text-red-600 font-bold bg-red-50 px-3 py-1 rounded-full text-[11px] border border-red-100">
                                                Rp {{ number_format($denda, 0, ',', '.') }}
                                            </span>
                                            @if ($loan->status == 'borrowed')
                                                <span class="text-[10px] text-red-400 font-medium">
                                                    Telat {{ $telatHari }} Hari
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs font-medium bg-gray-50 px-2 py-1 rounded-lg">
                                            Aman (Rp 0)
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-16 h-16 mb-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-serif">Belum ada aktivitas peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
