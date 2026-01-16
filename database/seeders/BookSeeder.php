<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $categoryIds = Categories::pluck('id')->toArray();

        if (empty($categoryIds)) {
            $cat = Categories::create(['name' => 'Umum']);
            $categoryIds[] = $cat->id;
        }

        for ($i = 1; $i <= 20; $i++) {
            Book::create([
                'name'          => $faker->sentence(3),
                'author'        => $faker->name(),
                'release_year'  => $faker->year(),
                'description'   => $faker->paragraph(3),
                'thumbnail'     => 'cover_default.jpg',
                'stock'         => $faker->numberBetween(5, 50),
                'category_id'   => $faker->randomElement($categoryIds),
            ]);
        }
    }
}
