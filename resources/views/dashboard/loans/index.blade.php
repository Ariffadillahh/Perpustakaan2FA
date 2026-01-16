@extends('layouts.dashboard')

@section('title', 'Riwayat Peminjaman')

@section('content')

    <div x-data="{
        open: false,
        loading: false,
        actionUrl: '',
        fineText: ''
    }">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Peminjaman</h2>

            <div class="flex w-full md:w-auto items-center gap-3">
                <form action="{{ route('loans.index') }}" method="GET" class="relative w-full md:w-72">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari peminjam atau buku..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c5a059] text-sm shadow-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Semua Transaksi</h3>
                <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-lg border">
                    Total: {{ $loans->total() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Buku</th>
                            <th class="px-6 py-4">Deadline (+7 Hari)</th>
                            <th class="px-6 py-4">Denda (Realtime)</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($loans as $loan)
                            @php
                                $tglPinjam = \Carbon\Carbon::parse($loan->loan_date)->setTimezone('Asia/Jakarta');
                                $deadline = $tglPinjam->copy()->addDays(7)->endOfDay();
                                $sekarang = \Carbon\Carbon::now('Asia/Jakarta');

                                $denda = 0;
                                $telatHari = 0;

                                if ($loan->status == 'borrowed' && $sekarang->gt($deadline)) {
                                    $telatHari = ceil(abs($sekarang->floatDiffInDays($deadline)));
                                    $denda = $telatHari * 1000;
                                } elseif ($loan->status == 'returned') {
                                    $denda = $loan->fine_amount ?? 0;
                                }
                            @endphp

                            <tr class="hover:bg-gray-50/50 transition-colors">

                                {{-- PEMINJAM --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-[#0f392b]/10 text-[#0f392b]
                                flex items-center justify-center text-xs font-bold">
                                            {{ substr($loan->user->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">
                                            {{ $loan->user->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- BUKU --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">
                                        {{ $loan->book->name }}
                                    </span>
                                </td>

                                {{-- DEADLINE --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400">
                                            Pinjam: {{ $tglPinjam->format('d M') }}
                                        </span>
                                        <span
                                            class="text-sm font-bold {{ $sekarang->gt($deadline) && $loan->status == 'borrowed' ? 'text-red-500' : 'text-gray-700' }}">
                                            {{ $deadline->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- DENDA --}}
                                <td class="px-6 py-4">
                                    @if ($denda > 0)
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="text-red-600 font-bold bg-red-50 px-3 py-1 rounded-full text-[11px] border w-fit">
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

                                {{-- STATUS --}}
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border
                            {{ $loan->status == 'borrowed'
                                ? 'bg-blue-50 text-blue-600 border-blue-100'
                                : 'bg-green-50 text-green-600 border-green-100' }}">
                                        {{ $loan->status == 'borrowed' ? 'Sedang Dipinjam' : 'Dikembalikan' }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-4 text-right">
                                    @if ($loan->status == 'borrowed')
                                        <button
                                            @click="
                                    open = true;
                                    actionUrl = '{{ route('loans.updateStatus', $loan->id) }}';
                                    fineText = 'Rp {{ number_format($denda, 0, ',', '.') }}';
                                "
                                            class="bg-[#0f392b] text-[#c5a059] px-4 py-2 rounded-xl text-[11px]
                                font-bold hover:bg-black hover:scale-105 transition-all shadow-sm
                                flex items-center gap-2 ml-auto">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            ACC Kembali
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Selesai</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL --}}
        <div x-show="open" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div @click.outside="!loading && (open = false)"
                class="bg-white w-full max-w-md rounded-2xl shadow-xl border border-gray-100">

                <div class="px-6 py-4 border-b flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-[#0f392b]/10 text-[#0f392b] flex items-center justify-center">
                        ✓
                    </div>
                    <h3 class="font-bold text-sm">Konfirmasi Pengembalian</h3>
                </div>

                <div class="px-6 py-5 text-sm text-gray-600 space-y-3">
                    <p>Denda yang akan dicatat:</p>
                    <p class="font-bold text-red-600" x-text="fineText"></p>
                </div>

                <form :action="actionUrl" method="POST" @submit="loading = true"
                    class="px-6 py-4 border-t flex justify-end gap-3">
                    @csrf
                    @method('PATCH')

                    <button type="button" @click="open = false" :disabled="loading"
                        class="px-4 py-2 rounded-xl text-xs border">
                        Batal
                    </button>

                    <button type="submit" :disabled="loading"
                        class="px-4 py-2 rounded-xl text-xs font-bold bg-[#0f392b] text-[#c5a059]
                flex items-center gap-2 min-w-[120px] justify-center">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4" />
                            <path class="opacity-75" stroke-linecap="round" stroke-width="4" d="M4 12a8 8 0 018-8" />
                        </svg>
                        <span x-text="loading ? 'Memproses...' : 'Konfirmasi'"></span>
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
