<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index()
    {
        $product = Product::all();

        if (! $product->count() == 0) {
            return response()->json(['products' => $product], 200);
        }

        return response()->json(['products' => 'Todavia no hay productos'], 204);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|gt:0',
            'categories' => 'required|array|min:1|max:4',
            'categories.*' => 'integer',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|between:10,157286400',
        ]);
        $id = Auth::id();

        $product = Product::create(
            ['name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'user_id' => 1,
            ]
        );

        $product->categories()->attatch($request->categories);

        foreach ($request->file('images') as $image) {
            $product->addMedia($image)->toMediaCollection('product');
        }

        $media = $product->getMedia('product')->map(function ($media) {
            return ['id' => $media->id, 'url' => $media->getUrl(), 'name' => $media->name];
        });

        return response()->json(['susses' => true, 'Message' => 'producto Creado Exitosamente', 'product' => $product, 'images' => $media], 201);

    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|gt:0',
            'categories' => 'required|array|min:1|max:4',
            'categories.*' => 'integer',
        ]);

        $product->categories()->sync($request->categories);
        $product->update($request->except('categories'));
    }
}
