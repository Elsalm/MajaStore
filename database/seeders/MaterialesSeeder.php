<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = [
            ['name' => 'metal'],
            ['name' => 'madera'],
            ['name' => 'piel'],
            ['name' => 'semipiel'],
            ['name' => 'tela'],
        ];

        foreach ($model as $material) {
            Material::create($material);
        }
    }
}
