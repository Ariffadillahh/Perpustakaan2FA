<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Staff / Pegawai
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'staff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Member
        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'member',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
