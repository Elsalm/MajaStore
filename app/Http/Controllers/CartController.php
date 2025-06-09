<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function get(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        return response()->json($cart);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|string',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$data['id']])) {
            $cart[$data['id']]['quantity'] += $data['quantity'];
        } else {
            $cart[$data['id']] = $data;
        }

        $request->session()->put('cart', $cart);

        return response()->json(['message' => 'Item added', 'cart' => $cart]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $data['quantity'];
            $request->session()->put('cart', $cart);

            return response()->json(['message' => 'Quantity updated', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);

            return response()->json(['message' => 'Item removed', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return response()->json(['message' => 'Cart cleared']);
    }
}
