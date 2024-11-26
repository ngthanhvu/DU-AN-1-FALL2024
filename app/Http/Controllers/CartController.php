<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Users;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        Log::info('Request data:', $request->all());

        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'guest_id' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string'
        ]);

        Log::info('Validated data:', $validatedData);

        if (isset($validatedData['user_id'])) {
            $user = Users::find($validatedData['user_id']);
            if (!$user) {
                Log::error('Invalid user id:', $validatedData['user_id']);
                return response()->json(['message' => 'The selected user id is invalid.'], 422);
            }
        }

        $cartItemQuery = Cart::where('product_id', $validatedData['product_id'])
            ->where('size', $validatedData['size']);

        if (isset($validatedData['user_id'])) {
            $cartItemQuery->where('user_id', $validatedData['user_id']);
        } else if (isset($validatedData['guest_id'])) {
            $cartItemQuery->where('guest_id', $validatedData['guest_id']);
        }

        $cartItem = $cartItemQuery->first();

        if ($cartItem) {
            $cartItem->quantity += $validatedData['quantity'];
        } else {
            $cartItem = new Cart($validatedData);
        }

        $cartItem->save();

        return response()->json(['message' => 'Product added to cart successfully'], 200);
    }

    public function getCart(Request $request)
    {
        $userId = $request->input('user_id');
        $guestId = $request->input('guest_id');

        if ($userId) {
            $cartItems = Cart::where('user_id', $userId)->get();
        } elseif ($guestId) {
            $cartItems = Cart::where('guest_id', $guestId)->get();
        } else {
            return response()->json(['message' => 'No cart found'], 404);
        }

        return response()->json($cartItems, 200);
    }

    public function index()
    {
        return response()->json(Cart::all(), 200);
    }

    public function removeFromCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $guest_id = $request->input('guest_id');
        $user_id = $request->input('user_id');

        if ($user_id) {
            Cart::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        } else {
            Cart::where('product_id', $product_id)->delete();
        }

        if ($guest_id) {
            Cart::where('guest_id', $guest_id)->where('product_id', $product_id)->delete();
        } else {
            Cart::where('product_id', $product_id)->delete();
        }

        return response()->json(['message' => 'Product removed from cart successfully'], 200);
    }

    public function updateQuantity(Request $request)
    {
        $validatedData = $request->validate([
            'cart_id' => 'required|integer|exists:cart_items,id', // ID của sản phẩm trong giỏ hàng
            'quantity' => 'required|integer|min:1' // Số lượng muốn cập nhật
        ]);

        // Tìm sản phẩm trong giỏ hàng
        $cartItem = Cart::find($validatedData['cart_id']);

        if ($cartItem) {
            // Cập nhật số lượng sản phẩm
            $cartItem->quantity = $validatedData['quantity'];
            $cartItem->save();

            return response()->json(['message' => 'Quantity updated successfully'], 200);
        }

        return response()->json(['message' => 'Cart item not found'], 404);
    }
}
