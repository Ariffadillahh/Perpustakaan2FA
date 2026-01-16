@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div x-data="userHandler()">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 font-serif">Daftar Pengguna</h2>
                <p class="text-sm text-gray-500">Kelola role dan status akses pengguna.</p>
            </div>

            <div class="flex w-full md:w-auto gap-3">
                <form action="{{ route('admin.index') }}" method="GET" class="relative w-full md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#c5a059] text-sm shadow-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>

                <button @click="openModal('add')"
                    class="bg-[#0f392b] text-white px-5 py-2.5 rounded-xl font-medium hover:bg-[#09221a] transition shadow-lg flex items-center justify-center gap-2 whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span class="hidden sm:inline">User Baru</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TABEL USER --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status Akun</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#0f392b] text-[#c5a059] flex items-center justify-center font-bold text-lg border-2 border-[#c5a059]">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                            {{-- Menampilkan No HP jika ada (Opsional) --}}
                                            @if ($user->phone_number)
                                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $user->phone_number }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->role_id == 1)
                                        <span
                                            class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-[10px] font-bold border border-purple-200 uppercase">Admin</span>
                                    @elseif($user->role_id == 2)
                                        <span
                                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold border border-blue-200 uppercase">Petugas</span>
                                    @else
                                        <span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold border border-green-200 uppercase">Anggota</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($user->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        {{-- Tombol Edit --}}
                                        <button @click="openModal('edit', {{ $user }})"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                            title="Edit Akses">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->appends(['search' => request('search')])->links('pagination.custom') }}
            </div>
        </div>

        {{-- MODAL FORM --}}
        <div x-show="isModalOpen"
            class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4" x-cloak
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all"
                @click.outside="isModalOpen = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="scale-95 opacity-0 translate-y-4"
                x-transition:enter-end="scale-100 opacity-100 translate-y-0">

                <div class="px-6 py-4 bg-[#0f392b] border-b border-[#c5a059]/20 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#c5a059]" x-text="modalTitle"></h3>
                    <button @click="isModalOpen = false" class="text-white/70 hover:text-white transition"><svg
                            class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg></button>
                </div>

                <form :action="formAction" method="POST" class="p-6 space-y-5">
                    @csrf
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    {{-- Nama & Email (Readonly saat Edit) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" x-model="form.name" :readonly="isEdit"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm outline-none transition"
                                :class="isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed' :
                                    'focus:border-[#0f392b] focus:ring-2 focus:ring-[#c5a059]/20'">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Email</label>
                            <input type="email" name="email" x-model="form.email" :readonly="isEdit"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm outline-none transition"
                                :class="isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed' :
                                    'focus:border-[#0f392b] focus:ring-2 focus:ring-[#c5a059]/20'">
                        </div>
                    </div>

                    {{-- No Handphone (Baru) --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">No. Handphone</label>
                        <input type="text" name="phone" x-model="form.phone"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#c5a059]/20 outline-none transition text-sm"
                            placeholder="08123456789">
                        <p x-show="isEdit" class="text-[10px] text-red-400 mt-1 italic">*Boleh diedit jika perlu</p>
                    </div>

                    {{-- Password (Hanya muncul saat Add New) --}}
                    <div x-show="!isEdit">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Password Awal</label>
                        <input type="password" name="password" x-model="form.password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#0f392b] focus:ring-2 focus:ring-[#c5a059]/20 outline-none transition"
                            placeholder="********">
                    </div>

                    {{-- Role Selection --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Role Akun</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ([3 => 'Anggota', 2 => 'Petugas', 1 => 'Admin'] as $val => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="role_id" value="{{ $val }}"
                                        x-model="form.role_id" class="peer sr-only">
                                    <div
                                        class="rounded-xl border border-gray-200 py-2.5 text-center text-xs font-bold text-gray-500 hover:bg-gray-50 
                                peer-checked:border-[#0f392b] peer-checked:bg-[#0f392b] peer-checked:text-[#c5a059] transition-all">
                                        {{ $label }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Status Akun (Toggle) --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Status Akun</label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" x-model="form.is_active"
                                class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0f392b]">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-700"
                                x-text="form.is_active ? 'Aktif' : 'Non-Aktif'"></span>
                        </label>
                    </div>

                    <div class="pt-4 flex gap-3 border-t border-gray-100">
                        <button type="button" @click="isModalOpen = false"
                            class="w-full py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition text-sm">Batal</button>
                        <button type="submit"
                            class="w-full py-3 bg-[#0f392b] text-[#c5a059] font-bold rounded-xl hover:bg-[#0a261d] shadow-lg transition text-sm">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function userHandler() {
            return {
                isModalOpen: false,
                isEdit: false,
                modalTitle: '',
                formAction: '',
                form: {
                    name: '',
                    email: '',
                    phone: '', // Data untuk form phone
                    password: '',
                    role_id: '3',
                    is_active: true
                },
                openModal(type, data = null) {
                    this.isModalOpen = true;
                    this.isEdit = (type === 'edit');
                    this.modalTitle = this.isEdit ? 'Edit Akses Pengguna' : 'Tambah Pengguna Baru';

                    if (this.isEdit && data) {
                        this.formAction = `/users/${data.id}`;
                        this.form.name = data.name;
                        this.form.email = data.email;
                        // Ambil data phone_number dari user (yang otomatis terdekripsi oleh Model User)
                        this.form.phone = data.phone_number || '';
                        this.form.role_id = data.role_id;
                        this.form.is_active = data.is_active == 1;
                        this.form.password = '';
                    } else {
                        // Perhatikan route ini
                        this.formAction = "{{ route('admin.create') }}";
                        this.form.name = '';
                        this.form.email = '';
                        this.form.phone = '';
                        this.form.password = '';
                        this.form.role_id = '3';
                        this.form.is_active = true;
                    }
                }
            }
        }
    </script>
@endsection
