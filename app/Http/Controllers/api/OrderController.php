<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder (Request $request) {
        $request->validate([
            'address_id' => 'required|integer',
            'seller_id' => 'required|integer',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'shipping_cost' => 'required|integer',
            'shipping_service' => 'required|string',
        ]);

        $user = $request->user()->id;

        $totalPrice = 0;
        foreach ( $request->items as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
        }

        $grandTotal = $totalPrice + $request->shipping_cost;

        $order = Order::create([
            'user_id' => $user,
            'address_id' => $request->address_id,
            'seller_id' => $request->seller_id,
            'total_price' => $totalPrice,
            'shipping_price' => $request->shipping_cost,
            'grand_total' => $grandTotal,
            'status' => 'PENDING',
            'transaction_number' => 'TRX-' . now()
        ]);

    }
}
