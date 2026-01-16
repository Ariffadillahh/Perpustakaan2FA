<?php

namespace Database\Seeders;

use App\Models\User; // <--- PENTING: Pake Model User, bukan DB::table
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@library.com',
            'password' => 'password123', 
            'phone_number' => '081234567890',
            'role_id' => 1,
            'email_verified_at' => now(),
        ]);

        // 2. Petugas
        User::create([
            'name' => 'Petugas Perpus',
            'email' => 'staff@library.com',
            'password' => 'password123',
            'phone_number' => '085790123456',
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        // 3. Anggota
        User::create([
            'name' => 'Anggota Biasa',
            'email' => 'member@library.com',
            'password' => 'password123',
            'phone_number' => '089623456781',
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);
    }
}
