<?php

namespace App\Http\Controllers;

use App\Models\Color;

class ColorsController extends Controller
{
    public function index()
    {
        $colors = Color::all();

        return response()->json(['succes' => true, 'colors' => $colors], 200);
    }
}
