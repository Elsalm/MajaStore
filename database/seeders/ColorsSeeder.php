<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = [
            ['name' => 'azul cielo', 'hexa' => '#87CEEB'],
            ['name' => 'rojo ladrillo', 'hexa' => '#B22222'],
            ['name' => 'verde bosque', 'hexa' => '#228B22'],
            ['name' => 'amarillo mostaza', 'hexa' => '#FFDB58'],
            ['name' => 'marrón tierra', 'hexa' => '#8B4513'],
        ];

        foreach ($model as $colors) {
            Color::create($colors);
        }
    }
}
