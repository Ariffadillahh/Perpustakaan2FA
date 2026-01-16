@extends('layouts.dashboard')

@section('title', 'Katalog Buku')

@section('content')

    <div class="md:flex md:justify-between mb-5 items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-serif">Katalog Buku</h1>
            <p class="text-sm text-gray-500">Kelola semua koleksi buku perpustakaan.</p>
        </div>

        <div class="flex flex-col md:flex-row gap-3 mt-4 md:mt-0">
            <form action="{{ route('books.index') }}" method="GET" class="relative group w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau penulis..."
                    class="pl-10 pr-4 py-2.5 w-full md:w-64 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition shadow-sm">
                <div class="absolute left-3 top-3 text-gray-400 group-focus-within:text-[#0f392b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            <a href="{{ route('books.create') }}"
                class="bg-[#0f392b] text-white px-5 py-2.5 rounded-xl font-medium hover:bg-[#09221a] transition shadow-lg flex items-center justify-center gap-2 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Buku
            </a>
        </div>
    </div>

    @if (session('success'))
        <div
            class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ showDeleteModal: false, deleteUrl: '' }">

        {{-- WRAPPER TABLE DENGAN SCROLL --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tahun Rilis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-16 bg-gray-100 rounded-lg overflow-hidden shadow-sm flex-shrink-0 border border-gray-200">
                                        @if ($book->thumbnail)
                                            <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="{{ $book->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $book->name }}</p>
                                        <p class="text-xs text-gray-500 italic mt-0.5">{{ $book->author }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-[#c5a059]/10 text-[#c5a059] px-3 py-1 rounded-full text-xs font-bold border border-[#c5a059]/20">
                                    {{ $book->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 font-bold text-sm">{{ $book->stock }} <span
                                        class="font-normal text-gray-500 text-xs">Eksemplar</span></span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 font-bold text-sm">{{ $book->release_year }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('books.edit', $book->id) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus dengan Trigger Modal --}}
                                    <button
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('books.destroy', $book->id) }}'"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">Data buku tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $books->appends(['search' => request('search')])->links('pagination.custom') }}
        </div>

        {{-- MODAL KONFIRMASI HAPUS --}}
        <div x-show="showDeleteModal"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 transform transition-all"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="scale-90 opacity-0"
                x-transition:enter-end="scale-100 opacity-100" @click.outside="showDeleteModal = false">

                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Hapus Buku?</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Tindakan ini tidak dapat dibatalkan. Buku yang dihapus akan hilang dari katalog secara permanen.
                    </p>
                </div>

                <div class="mt-6 flex gap-3">
                    <button @click="showDeleteModal = false" type="button"
                        class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0f392b] sm:text-sm transition">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
