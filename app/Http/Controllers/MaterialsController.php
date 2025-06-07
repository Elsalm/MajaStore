<?php

namespace App\Http\Controllers;

use App\Models\Material;

class MaterialsController extends Controller
{
    public function index()
    {
        $materials = Material::all();

        return response()->json(['succes' => true, 'materials' => $materials]);
    }
}
