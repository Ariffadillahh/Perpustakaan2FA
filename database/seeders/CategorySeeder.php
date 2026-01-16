<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Novel',
            'Komik',
            'Ensiklopedia',
            'Biografi',
            'Sains & Teknologi',
            'Sejarah',
            'Bisnis & Ekonomi',
            'Pengembangan Diri',
            'Agama',
            'Kesehatan',
            'Pemrograman',
            'Desain Grafis'
        ];

        foreach ($data as $catName) {
            Categories::firstOrCreate([
                'name' => $catName
            ]);
        }
    }
}
