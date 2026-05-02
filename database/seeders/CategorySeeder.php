<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Musik',       'description' => 'Konser, festival musik, dan pertunjukan band.'],
            ['name' => 'Olahraga',    'description' => 'Turnamen, lomba lari, dan kegiatan olahraga.'],
            ['name' => 'Kuliner',     'description' => 'Festival makanan dan minuman khas Bengkulu.'],
            ['name' => 'Budaya',      'description' => 'Pertunjukan seni dan budaya lokal.'],
            ['name' => 'Pendidikan',  'description' => 'Seminar, workshop, dan pelatihan.'],
            ['name' => 'Pariwisata',  'description' => 'Tour wisata dan jelajah alam Bengkulu.'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name'        => $cat['name'],
                'slug'        => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }
    }
}