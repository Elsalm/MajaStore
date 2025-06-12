<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
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
        $order->stripe_id = $response->id;
        $order->save();

        session()->put('cart', []);

        return response()->json(['url' => $response['url']]);
    }

    public function orderSuccess(Request $request)
    {
        return view('home.index', ['succes' => true]);
    }

    public function getUserOrders()
    {
        $user = Auth::user();

        $userWithDetails = User::with('order.products.product')->find($user->id);

        $formattedOrdersData = [];

        if ($userWithDetails && $userWithDetails->order->isNotEmpty()) {
            foreach ($userWithDetails->order as $order) {
                $orderProductsData = [];

                foreach ($order->products as $orderProduct) {
                    if ($orderProduct->product) {
                        $orderProductsData[] = [
                            'order_product_id' => $orderProduct->id,
                            'product_id' => $orderProduct->product->id,
                            'product_name' => $orderProduct->product->name,
                            'quantity' => $orderProduct->quantity,
                            'price' => $orderProduct->price,
                            'total_line_item' => $orderProduct->total,
                        ];
                    }
                }

                $formattedOrdersData[] = [
                    'order_id' => $order->id,
                    'order_amount' => $order->amount,
                    'order_status' => $order->status,
                    'products' => $orderProductsData,
                ];
            }
        }

        return response()->json(['order' => $formattedOrdersData], 200);
    }

    public function cancelOrder($id)
    {
        dd($id);
        $order = Order::findOrFail($id);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $stripeSessionId = $order->stripe_id;

        if (! $stripeSessionId) {
            return response()->json(['error' => 'Stripe session ID not found'], 400);
        }

        try {
            $session = $stripe->checkout->sessions->retrieve($stripeSessionId);
            $paymentIntentId = $session->payment_intent;

            $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

            if (in_array($paymentIntent->status, ['requires_capture', 'requires_payment_method'])) {
                // Cancelar pago no capturado
                $stripe->paymentIntents->cancel($paymentIntentId);
            } elseif ($paymentIntent->status === 'succeeded') {
                // Reembolsar pago capturado
                $stripe->refunds->create(['payment_intent' => $paymentIntentId]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $order->status = -1;
        $order->save();

        return response()->json(['message' => 'Order cancelled or refunded']);
    }

    public function getCanceledOrder()
    {
        $orders = Order::with('products.product')
            ->where('status', -1)
            ->get();

        $formattedOrdersData = [];

        foreach ($orders as $order) {
            $orderProductsData = [];

            foreach ($order->products as $orderProduct) {
                if ($orderProduct->product) {
                    $orderProductsData[] = [
                        'order_product_id' => $orderProduct->id,
                        'product_id' => $orderProduct->product->id,
                        'product_name' => $orderProduct->product->name,
                        'quantity' => $orderProduct->quantity,
                        'price' => $orderProduct->price,
                        'total_line_item' => $orderProduct->total,
                    ];
                }
            }

            $formattedOrdersData[] = [
                'order_id' => $order->id,
                'order_amount' => $order->amount,
                'order_status' => $order->status,
                'products' => $orderProductsData,
            ];
        }

        return response()->json(['order' => $formattedOrdersData], 200);
    }

    public function getAllOrders()
    {
        $ordersWithDetails = Order::with(['products.product', 'user'])->get();
        $formattedOrdersData = [];

        if ($ordersWithDetails->isNotEmpty()) {
            foreach ($ordersWithDetails as $order) {
                $orderProductsData = [];
                foreach ($order->products as $orderProduct) {
                    if ($orderProduct->product) {
                        $orderProductsData[] = [
                            'order_product_id' => $orderProduct->id,
                            'product_id' => $orderProduct->product->id,
                            'product_name' => $orderProduct->product->name,
                            'quantity' => $orderProduct->quantity,
                            'price' => $orderProduct->price,
                            'total_line_item' => $orderProduct->total,
                        ];
                    }
                }
                $formattedOrdersData[] = [
                    'order_id' => $order->id,
                    'order_amount' => $order->amount,
                    'order_status' => $order->status,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user ? $order->user->name : null,
                    'products' => $orderProductsData,
                ];
            }
        }

        return response()->json(['orders' => $formattedOrdersData], 200);
    }

    public function update($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 1;
        $order->save();

        return response()->json(['status' => 1], 200);

    }
}
