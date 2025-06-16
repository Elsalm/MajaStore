<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sofas'],
            ['name' => 'Sillas'],
            ['name' => 'Mesas'],
            ['name' => 'Camas'],
            ['name' => 'Almacenamiento y Armarios '],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
