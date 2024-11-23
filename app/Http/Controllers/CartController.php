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
        // In ra dữ liệu nhận được từ request
        Log::info('Request data:', $request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'guest_id' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string'
        ]);

        Log::info('Validated data:', $validatedData);

        // Xác nhận user_id hoặc guest_id
        if (isset($validatedData['user_id'])) {
            $user = Users::find($validatedData['user_id']);
            if (!$user) {
                Log::error('Invalid user id:', $validatedData['user_id']);
                return response()->json(['message' => 'The selected user id is invalid.'], 422);
            }
        }

        // Check if the cart item already exists for the user or guest
        $cartItemQuery = Cart::where('product_id', $validatedData['product_id'])
            ->where('size', $validatedData['size']);

        if (isset($validatedData['user_id'])) {
            $cartItemQuery->where('user_id', $validatedData['user_id']);
        } else if (isset($validatedData['guest_id'])) {
            $cartItemQuery->where('guest_id', $validatedData['guest_id']);
        }

        $cartItem = $cartItemQuery->first();

        if ($cartItem) {
            // If the item exists, update the quantity
            $cartItem->quantity += $validatedData['quantity'];
        } else {
            // If the item does not exist, create a new record
            $cartItem = new Cart($validatedData);
        }

        // Save the cart item
        $cartItem->save();

        return response()->json(['message' => 'Product added to cart successfully'], 200);
    }

    public function getCart(Request $request)
    {
        $userId = $request->input('user_id');
        $guestId = $request->input('guest_id');

        // Lấy dữ liệu giỏ hàng cho user_id hoặc guest_id
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
        $user_id = $request->input('user_id');
        $guest_id = $request->input('guest_id');

        // Xóa dữ liệu giỏ hàng cho user_id hoặc guest_id
        if ($user_id) {
            Cart::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        } elseif ($guest_id) {
            Cart::where('guest_id', $guest_id)->where('product_id', $product_id)->delete();
        } else {
            return response()->json(['message' => 'No cart found'], 404);
        }

        return response()->json(['message' => 'Product removed from cart successfully'], 200);
    }
}
