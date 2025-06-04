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
            ['name' => 'Sala'],
            ['name' => 'Cuarto'],
            ['name' => 'Comedor'],
            ['name' => 'Oficina'],
            ['name' => 'Almacenamiento'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}
