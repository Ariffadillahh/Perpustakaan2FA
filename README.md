# 📚 Sistem Informasi Perpustakaan Digital

Aplikasi manajemen perpustakaan berbasis web yang dibangun menggunakan **Laravel 12**, **MySQL**, dan **Tailwind CSS**. Aplikasi ini dirancang untuk memudahkan pengelolaan buku, peminjaman, anggota, serta dilengkapi fitur keamanan dan *backup* database otomatis.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=flat&logo=tailwind-css&logoColor=white)

## 🚀 Fitur Utama

- **Autentikasi & Otorisasi:** Login, Register, Lupa Password (OTP), 2FA (Two-Factor Authentication), dan Multi-role (Admin, Petugas, Anggota).
- **Manajemen Buku:** CRUD Buku, Kategori, Stok Otomatis, dan Pencarian.
- **Sirkulasi:** Peminjaman dan Pengembalian buku.
- **Denda Otomatis:** Perhitungan denda jika pengembalian terlambat.
- **Dashboard Admin:** Statistik real-time, Grafik, dan Manajemen User.
- **Backup & Restore:** Fitur backup database dan restore langsung dari antarmuka Admin.
- **User Interface:** Desain responsif dan modern dengan Tailwind CSS & Alpine.js.

---

## 🛠️ Persyaratan Sistem (Requirements)

Sebelum memulai, pastikan komputer Anda memiliki:

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM

---

## 📥 Cara Install & Menjalankan (Installation)

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal (Localhost):

### 1. Clone Repository
Buka terminal (CMD/Git Bash) dan jalankan perintah:

```bash
git clone https://github.com/Ariffadillahh/Perpustakaan2FA.git
cd Perpustakaan2FA 
```

### Install Dependencies

```bash
composer install
npm install
```

### Konfigurasi Environment
Duplikat file .env.example menjadi .env
```bash
cp .env.example .env
```

Generate App Key:
```bash
php artisan key:generate
```

### Setup Storage

```bash
php artisan storage:link
```

### ⚡ Migrate & Seeder (Penting!)

```bash
php artisan migrate:fresh --seed
```

### ▶️ Menjalankan Aplikasi

Terminal 1 (Vite/Frontend):

```bash
npm run dev
```

Terminal 2 (Laravel Server):

```bash
php artisan serve
```

### 🔑 Akun Default (Testing)

role Admin 
email admin@library.com
password password123

role Petugas 
email staff@library.com
password password123

role Member 
email member@library.com
password password123
