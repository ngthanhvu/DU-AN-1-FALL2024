<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'hamlet' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:cod,vnpay,momo',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order
        ], 201);
    }
}
