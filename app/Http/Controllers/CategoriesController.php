<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return response()->json(['succes' => true, 'category' => $category]);
    }

    public function getIdByName($name)
    {

        $category = Category::whereLike('name', '%'.$name.'%', caseSensitive: false)->get();

        $category = $category->first()->id;

        return view('products.filter', compact('category'));

    }
}
