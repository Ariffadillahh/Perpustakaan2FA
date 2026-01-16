@extends('layouts.dashboard')

@section('title')
    Dashboard {{ ucfirst(Auth::user()->role->name ?? 'Admin') }}
@endsection

@section('content')

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
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

    <div
        class="bg-gradient-to-r from-[#0f392b] to-[#1a5f48] rounded-2xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/2 bg-[#c5a059]/10 skew-x-12"></div>
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-2 font-serif">Halo, {{ Auth::user()->name }}! </h1>
            <p class="text-white/80">Selamat datang kembali. Kelola perpustakaan dengan mudah.</p>
        </div>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Koleksi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBooks ?? 0 }} Buku</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $activeLoans ?? 0 }} Transaksi</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Total Anggota</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalMembers ?? 0 }} User</p>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN CRUD KATEGORI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8" x-data="{
        createCategoryModal: false,
        editCategoryModal: false,
        deleteCategoryModal: false,
        selectedCatId: '',
        selectedCatName: '',
        updateAction: '',
        deleteAction: ''
    }">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-lg text-gray-800 font-serif">Kategori Buku</h3>
                <p class="text-xs text-gray-500">Kelola kategori untuk pengelompokan buku.</p>
            </div>
            <button @click="createCategoryModal = true"
                class="bg-[#0f392b] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-[#0a261d] shadow-lg flex items-center gap-2 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase font-bold border-b border-gray-100">
                        <th class="pb-3 pl-2">No</th>
                        <th class="pb-3">Nama Kategori</th>
                        <th class="pb-3">Slug</th>
                        <th class="pb-3 text-right pr-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($categories ?? [] as $index => $category)
                        <tr class="hover:bg-gray-50 border-b border-gray-50 last:border-0">
                            <td class="py-4 pl-2 text-gray-500 font-mono">{{ $index + 1 }}</td>
                            <td class="py-4 font-bold text-gray-800">{{ $category->name }}</td>
                            <td class="py-4 text-gray-500 italic text-xs">{{ Str::slug($category->name) }}</td>
                            <td class="py-4 text-right pr-2">
                                <div class="flex justify-end gap-2">
                                    {{-- Tombol Edit --}}
                                    <button
                                        @click="editCategoryModal = true; selectedCatName = '{{ $category->name }}'; updateAction = '{{ route('categories.update', $category->id) }}'"
                                        class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    {{-- Tombol Hapus --}}
                                    <button
                                        @click="deleteCategoryModal = true; deleteAction = '{{ route('categories.destroy', $category->id) }}'; selectedCatName = '{{ $category->name }}'"
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <td colspan="4" class="py-8 text-center text-gray-400">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODAL TAMBAH KATEGORI --}}
        <div x-show="createCategoryModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl transform transition-all"
                @click.away="createCategoryModal = false">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Tambah Kategori</h3>
                <form action="{{ route('categories.store') }}" method="POST" class="cat-form">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Kategori</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#c5a059] focus:border-[#c5a059] outline-none text-sm"
                            placeholder="Contoh: Novel, Sains...">
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="createCategoryModal = false"
                            class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 text-sm">Batal</button>
                        <button type="submit"
                            class="w-full py-3 bg-[#0f392b] text-[#c5a059] font-bold rounded-xl hover:bg-[#0a261d] shadow-lg text-sm flex items-center justify-center gap-2 btn-submit-cat">
                            <span class="spinner hidden"><svg class="animate-spin h-4 w-4 text-[#c5a059]"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg></span>
                            <span class="text">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL EDIT KATEGORI --}}
        <div x-show="editCategoryModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl transform transition-all"
                @click.away="editCategoryModal = false">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Edit Kategori</h3>
                <form :action="updateAction" method="POST" class="cat-form">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Kategori</label>
                        <input type="text" name="name" x-model="selectedCatName" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#c5a059] focus:border-[#c5a059] outline-none text-sm">
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="editCategoryModal = false"
                            class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 text-sm">Batal</button>
                        <button type="submit"
                            class="w-full py-3 bg-[#0f392b] text-[#c5a059] font-bold rounded-xl hover:bg-[#0a261d] shadow-lg text-sm flex items-center justify-center gap-2 btn-submit-cat">
                            <span class="spinner hidden"><svg class="animate-spin h-4 w-4 text-[#c5a059]"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg></span>
                            <span class="text">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL DELETE KATEGORI --}}
        <div x-show="deleteCategoryModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
            <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl transform transition-all"
                @click.away="deleteCategoryModal = false">
                <div class="text-center mb-6">
                    <div
                        class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Hapus Kategori?</h3>
                    <p class="text-sm text-gray-500 mt-2">Kategori <span class="font-bold text-red-600"
                            x-text="selectedCatName"></span> akan dihapus permanen.</p>
                </div>
                <form :action="deleteAction" method="POST" class="cat-form">
                    @csrf @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" @click="deleteCategoryModal = false"
                            class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 text-sm">Batal</button>
                        <button type="submit"
                            class="w-full py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg text-sm flex items-center justify-center gap-2 btn-submit-cat">
                            <span class="spinner hidden"><svg class="animate-spin h-4 w-4 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg></span>
                            <span class="text">Ya, Hapus</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (Auth::check() && Auth::user()->role_id === 1)
        {{--  BACKUP & RESTORE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" x-data="{
            restoreModal: false,
            deleteModal: false,
            selectedBackupId: '',
            selectedDate: '',
            deleteAction: ''
        }">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-lg text-gray-800 font-serif">Riwayat Backup Database</h3>
                    <p class="text-xs text-gray-500">Daftar file cadangan database yang tersedia.</p>
                </div>

                {{-- FORM BACKUP (Create) --}}
                <form id="backup-form" action="{{ route('backups.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="type" value="full">

                    <input type="password" id="backup-password" name="password" placeholder="Password Backup..."
                        required
                        class="px-3 py-2 border rounded-xl text-sm focus:ring-[#c5a059] w-40 disabled:bg-gray-100">

                    <button type="submit" id="backup-btn"
                        class="bg-[#0f392b] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-[#0a261d] shadow-lg flex items-center gap-2 transition-all">

                        <span id="btn-icon-normal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                        </span>
                        <span id="btn-icon-loading" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        <span id="btn-text">Backup Sekarang</span>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase font-bold border-b border-gray-100">
                            <th class="pb-3 pl-2">Tanggal Backup</th>
                            <th class="pb-3">Nama File</th>
                            <th class="pb-3">Dibuat Oleh</th>
                            <th class="pb-3 text-right pr-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($backups ?? [] as $backup)
                            <tr class="hover:bg-gray-50 group transition-colors border-b border-gray-50 last:border-0">
                                <td class="py-4 pl-2">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">
                                                {{ \Carbon\Carbon::parse($backup->backup_at)->setTimezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($backup->backup_at)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                                WIB
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4">
                                    <span class="font-mono text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">
                                        {{ $backup->file_name }}
                                    </span>
                                </td>

                                <td class="py-4">
                                    <span class="text-gray-700 font-medium">{{ $backup->user->name ?? 'Sistem' }}</span>
                                </td>

                                <td class="py-4 text-right pr-2">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            @click="restoreModal = true; selectedBackupId = '{{ $backup->id }}'; selectedDate = '{{ \Carbon\Carbon::parse($backup->backup_at)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}'"
                                            class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            Restore
                                        </button>

                                        <button
                                            @click="deleteModal = true; deleteAction = '{{ route('backups.destroy', $backup->id) }}'; selectedDate = '{{ \Carbon\Carbon::parse($backup->backup_at)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}'"
                                            class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p>Belum ada riwayat backup.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ================= MODAL RESTORE  ================= --}}
            <div x-show="restoreModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl transform transition-all"
                    @click.away="restoreModal = false">
                    <div class="text-center mb-6">
                        <div
                            class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Restore</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Mengembalikan database ke tanggal: <br>
                            <span class="font-bold text-[#0f392b]" x-text="selectedDate"></span>
                        </p>
                        <p class="text-xs text-red-500 mt-3 font-bold bg-red-50 p-2 rounded-lg border border-red-100">
                            PERINGATAN: Data saat ini akan ditimpa!
                        </p>
                    </div>

                    <form id="restore-form" :action="'/backups/' + selectedBackupId + '/restore'" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Password Backup</label>
                            <input type="password" id="restore-password" name="password" required
                                placeholder="Masukkan password backup..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-[#c5a059] focus:border-[#c5a059] outline-none text-sm">
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="restoreModal = false"
                                class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 text-sm">Batal</button>

                            <button type="submit" id="restore-btn"
                                class="w-full py-3 bg-[#0f392b] text-[#c5a059] font-bold rounded-xl hover:bg-[#0a261d] shadow-lg text-sm flex items-center justify-center gap-2">
                                <span id="restore-spinner" class="hidden">
                                    <svg class="animate-spin h-4 w-4 text-[#c5a059]" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                <span id="restore-text">Proses Restore</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ================= MODAL DELETE ================= --}}
            <div x-show="deleteModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl transform transition-all"
                    @click.away="deleteModal = false">
                    <div class="text-center mb-6">
                        <div
                            class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Hapus Backup?</h3>
                        <p class="text-sm text-gray-500 mt-2">
                            Anda yakin ingin menghapus backup tanggal:<br>
                            <span class="font-bold text-red-600" x-text="selectedDate"></span>
                        </p>
                        <p class="text-xs text-red-500 mt-3 bg-red-50 p-2 rounded-lg border border-red-100">
                            Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>

                    <form id="delete-form-modal" :action="deleteAction" method="POST">
                        @csrf @method('DELETE')

                        <div class="flex gap-3">
                            <button type="button" @click="deleteModal = false"
                                class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 text-sm">
                                Batal
                            </button>

                            <button type="submit" id="delete-btn-modal"
                                class="w-full py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg text-sm flex items-center justify-center gap-2">

                                <span id="delete-spinner-modal" class="hidden">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>

                                <span id="delete-text-modal">Ya, Hapus</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const backupForm = document.getElementById('backup-form');
            if (backupForm) {
                backupForm.addEventListener('submit', function() {
                    const btn = document.getElementById('backup-btn');
                    const iconNormal = document.getElementById('btn-icon-normal');
                    const iconLoading = document.getElementById('btn-icon-loading');
                    const btnText = document.getElementById('btn-text');
                    const inputPass = document.getElementById('backup-password');

                    btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    btn.style.pointerEvents = 'none';
                    inputPass.readOnly = true;

                    iconNormal.classList.add('hidden');
                    iconLoading.classList.remove('hidden');
                    btnText.innerText = 'Memproses...';
                });
            }

            const restoreForm = document.getElementById('restore-form');
            if (restoreForm) {
                restoreForm.addEventListener('submit', function() {
                    const btn = document.getElementById('restore-btn');
                    const spinner = document.getElementById('restore-spinner');
                    const text = document.getElementById('restore-text');
                    const inputPass = document.getElementById('restore-password');

                    btn.classList.add('opacity-75', 'cursor-wait');
                    btn.style.pointerEvents = 'none';
                    inputPass.readOnly = true;

                    spinner.classList.remove('hidden');
                    text.innerText = 'Sedang Merestore...';
                });
            }

            const deleteFormModal = document.getElementById('delete-form-modal');
            if (deleteFormModal) {
                deleteFormModal.addEventListener('submit', function() {
                    const btn = document.getElementById('delete-btn-modal');
                    const spinner = document.getElementById('delete-spinner-modal');
                    const text = document.getElementById('delete-text-modal');

                    btn.classList.add('opacity-75', 'cursor-wait');
                    btn.style.pointerEvents = 'none';

                    spinner.classList.remove('hidden');
                    text.innerText = 'Menghapus...';
                });
            }

            document.querySelectorAll('.cat-form').forEach(form => {
                form.addEventListener('submit', function() {
                    const btn = this.querySelector('.btn-submit-cat');
                    const spinner = btn.querySelector('.spinner');
                    const text = btn.querySelector('.text');

                    btn.classList.add('opacity-75', 'cursor-wait');
                    btn.style.pointerEvents = 'none';
                    spinner.classList.remove('hidden');
                    text.innerText = 'Memproses...';
                });
            });
        });
    </script>
@endsection
