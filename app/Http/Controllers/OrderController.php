<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $order = Order::create([
            'user_id' => $user->id,
        ]);
        $amount = 0;
        foreach (session('cart') as $model) {
            $cu = $order->products()->create([
                'product_id' => $model['id'],
                'quantity' => $model['quantity'],
                'price' => $model['price'],
            ]);
            $amount += $model['quantity'] * $model['price'];
        }
        $order->amount = $amount;

        $order->save();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $success = route('order.success').'?sessions_id={CHECKOUT_SESSION_ID}&order_id='.$order->id;
        $response = $stripe->checkout->sessions->create([
            'success_url' => $success,
            'customer_email' => $user->email,
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'Sipping MajaStore',
                        ],
                        'unit_amount' => 100 * $amount,
                        'currency' => 'EUR',
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);

        return response()->json(['url' => $response['url']]);
    }

    public function orderSuccess(Request $request)
    {
        dd($request->all());
    }
}
