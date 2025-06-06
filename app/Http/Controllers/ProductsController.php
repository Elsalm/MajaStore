<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:1',
            'categories' => 'required|array|min:1|max:4',
            'categories.*' => 'integer',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|between:10,157286400',
        ]);

        $product = Product::create(
            ['user_id' => 1, ...$request->except(['images', 'categories'])]
        );

        $product->categories()->attach($request->categories);

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

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['susses' => 'El producto se ha eliminado correctamente'], 204);
    }

    // solo para aclarar esto es temporal ya despues lo hare en base a las ventas 👌;
    public function featuredProducts()
    {
        $products = Product::with('categories')->take(4)->get()->map(function ($product) {
            return [
                'product' => $product,
                'media' => $product->getFirstMediaUrl('product'),
            ];
        });

        return response()->json($products);
    }
}
