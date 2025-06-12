<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.filter');
    }

    public function show(Product $product)
    {
        $product->load('categories');
        $product->load('colors');
        $product->load('materials');

        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'color' => $product->colors,
            'description' => $product->description,
            'material' => $product->materials->pluck('name', 'id'),
            'images' => $product->getMedia('product')->map(function ($img) {
                return $img['original_url'];
            }),
            'categories' => $product->categories->pluck('name', 'id'),
        ];

        return view('products.index', compact('data'));
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
            'categories.*' => 'string',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image',
            'colors' => 'required|array|min:1|max:5',
            'colors.*' => 'integer',
            'materials' => 'required|array|min:1|max:5',
            'materials.*' => 'string',
        ]);

        $product = Product::create(
            ['user_id' => 1, ...$request->except(['images', 'categories'])]
        );

        $categories = Category::whereIn('name', $request->input('categories'))->pluck('id')->toArray();

        $materials = Material::whereIn('name', $request->input('categories'))->pluck('id')->toArray();

        $product->categories()->attach($categories);
        $product->colors()->attach($request->input('colors'));
        $product->materials()->attach($materials);

        foreach ($request->file('images') as $image) {
            $name = Str::uuid().'.'.$image->getClientOriginalExtension();
            $product->addMedia($image)
                ->usingFileName($name)
                ->toMediaCollection('product');
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
        $products = Product::with('categories')
            ->take(4)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'material' => $product->material,
                    'image_url' => $product->getFirstMediaUrl('product'),
                    'categories' => $product->categories->pluck('name'),
                ];
            });

        return response()->json(['success' => true, 'products' => $products]);
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

        $results = $query->paginate(10);

        if ($results->isEmpty()) {
            return response()->json(['success' => true, 'products' => [], 'pagination' => null], 404);
        }

        $products = $results->getCollection()->map(fn ($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'color' => $product->color,
            'material' => $product->material,
            'image_url' => $product->getFirstMediaUrl('product'),
            'categories' => $product->categories->pluck('name'),
        ]);

        return response()->json([
            'success' => true,
            'products' => $products,
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
            ],
        ]);
    }

    public function getProductsByName(Request $request)
    {
        $search = strtolower($request->input('search'));
        $products = Product::whereLike('name', '%'.$search.'%')->limit(6)->get();
        $results = [];
        foreach ($products as $model) {
            $results[] = [
                'id' => $model['id'],
                'name' => $model['name'],
                'price' => $model['price'],
                'img' => $model->getFirstMediaUrl('product'),
            ];
        }

        return response()->json(['success' => true, 'results' => $results]);
    }
}
