@extends('layouts.dashboard')

@section('title', 'Edit Buku')

@section('content')
    <div class="mx-auto">
        <div class="mb-6">
            <a href="{{ route('books.index') }}"
                class="text-sm text-gray-500 hover:text-[#0f392b] flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 font-serif">Edit Buku</h1>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data"
                id="editForm">
                @csrf
                @method('PUT')
                <div class="space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampul Buku</label>
                        <div class="flex flex-col md:flex-row gap-4 items-center">
                            <div
                                class="w-32 h-44 rounded-xl border-2 border-[#c5a059] overflow-hidden bg-gray-50 flex-shrink-0 shadow-sm relative group">
                                <img id="image-preview"
                                    src="{{ $book->thumbnail ? asset('storage/' . $book->thumbnail) : '' }}"
                                    class="w-full h-full object-cover {{ !$book->thumbnail ? 'hidden' : '' }}">
                                <div id="no-image-text"
                                    class="w-full h-full flex items-center justify-center text-gray-300 italic text-xs {{ $book->thumbnail ? 'hidden' : '' }}">
                                    No Image</div>
                                <div
                                    class="absolute inset-0 bg-black/40 items-center justify-center hidden group-hover:flex">
                                    <span class="text-white text-[10px] font-bold">PREVIEW</span>
                                </div>
                            </div>

                            <div class="flex-grow w-full">
                                <label for="thumbnail"
                                    class="flex flex-col items-center justify-center w-full h-44 border-2 @error('thumbnail') border-red-300 @else border-gray-300 @enderror border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="text-center p-4" id="upload-placeholder">
                                        <svg class="w-8 h-8 mb-3 text-gray-400 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <p class="text-sm text-gray-500">Klik untuk mengganti sampul</p>
                                        <p class="text-xs text-gray-400 mt-1 italic">Kosongkan jika tidak ingin ganti</p>
                                    </div>
                                    <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                        </div>
                        @error('thumbnail')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Buku</label>
                        <input type="text" name="name" value="{{ old('name', $book->name) }}"
                            class="w-full px-4 py-3 rounded-xl border @error('name') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Penulis</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}"
                                class="w-full px-4 py-3 rounded-xl border @error('author') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition">
                            @error('author')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category_id"
                                class="w-full px-4 py-3 rounded-xl border @error('category_id') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition bg-white">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Terbit</label>
                            <input type="number" name="release_year"
                                value="{{ old('release_year', $book->release_year) }}"
                                class="w-full px-4 py-3 rounded-xl border @error('release_year') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition"
                                placeholder="Contoh: 2024" min="1900" max="{{ date('Y') }}">
                            @error('release_year')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $book->stock) }}"
                                class="w-full px-4 py-3 rounded-xl border @error('stock') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition"
                                min="0">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Buku</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-xl border @error('description') border-red-300 @else border-gray-200 @enderror focus:border-[#0f392b] focus:ring-2 focus:ring-[#0f392b]/10 outline-none transition resize-none"
                            placeholder="Tulis sinopsis atau deskripsi singkat buku ini...">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" id="btnUpdate"
                            class="bg-[#0f392b] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#09221a] transition shadow-lg flex items-center justify-center min-w-[160px]">
                            <span id="btnUpdateText">Perbarui Buku</span>
                            <span id="btnUpdateLoading" class="hidden flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span>Menyimpan...</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // JS PREVIEW EDIT
        document.getElementById('thumbnail').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagePreview = document.getElementById('image-preview');
            const noImageText = document.getElementById('no-image-text');
            const placeholder = document.getElementById('upload-placeholder');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    noImageText.classList.add('hidden');
                    placeholder.querySelector('p.text-sm').innerHTML =
                        "Terpilih: <br><span class='text-[#0f392b]'>" + file.name + "</span>";
                }
                reader.readAsDataURL(file);
            }
        });

        // JS LOADING EDIT
        document.getElementById('editForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnUpdate');
            const text = document.getElementById('btnUpdateText');
            const loading = document.getElementById('btnUpdateLoading');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-wait');
            text.classList.add('hidden');
            loading.classList.remove('hidden');
        });
    </script>
@endsection
