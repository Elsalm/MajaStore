<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function show(Product $product) {}

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
            'colors' => 'required|array|min:1|max:5',
            'colors.*' => 'integer',
            'materials' => 'required|array|min:1|max:5',
            'materials.*' => 'integer',
        ]);

        $product = Product::create(
            ['user_id' => 1, ...$request->except(['images', 'categories'])]
        );

        $product->categories()->attach($request->input('categories'));
        $product->colors()->attach($request->input('colors'));
        $product->materials()->attach($request->input('materials'));

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

    public function getProducts(Request $request)
    {
        $categories = $request->input('categories');
        $colors = $request->input('colors');
        $materials = $request->input('materials');

        $query = Product::query();

        if (! empty($categories)) {
            $query->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $categories));
        }

        if (! empty($colors)) {
            $query->whereHas('colors', fn ($q) => $q->whereIn('colors.id', $colors));
        }

        if (! empty($materials)) {
            $query->whereHas('materials', fn ($q) => $q->whereIn('materials.id', $materials));
        }
        if ($query->count() === 0) {
            return response()->json(['success' => true, 'products' => 'no se han encontrado productos'], 404);
        }

        $results = $query->paginate(10);

        $results->setCollection(
            $results->getCollection()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'color' => $product->color,
                    'material' => $product->material,
                    'image_url' => $product->getFirstMediaUrl('product'),
                    'categories' => $product->categories->pluck('name'),
                ];
            })
        );

        return response()->json(['success' => true, 'products' => $results]);
    }
}
