<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'commune' => 'required|string|max:255',
            'hamlet' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:cod,vnpay,momo',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'province' => $request->province,
                'district' => $request->district,
                'commune' => $request->commune,
                'hamlet' => $request->hamlet,
                'total_price' => $request->total_price,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($request->products as $product) {
                $productDetails = Product::find($product['id']);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $productDetails->price,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi tạo đơn hàng', 'error' => $e->getMessage()], 500);
        }
        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order
        ], 201);
    }

    public function getOrderStatus($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        return response()->json($order);
    }

    public function getOrdersByUserId($userId)
    {
        // $orders = Order::where('user_id', $userId)->get();
        $orders = Order::with(['orderDetails.product'])->where('user_id', $userId)->get();

        return response()->json($orders);
    }

    public function getOdersAll()
    {
        $orders = Order::with(['orderDetails.product'])->get();
        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function deleteOrderById($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Xóa đơn hàng thành công'], 200);
    }

    public function decreaseQuantityInOrder(Request $request, $orderId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1', // Số lượng cần giảm từ đơn hàng
        ]);

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
        }

        $orderDetails = $order->orderDetails;

        if ($orderDetails->isEmpty()) {
            return response()->json(['error' => 'Đơn hàng này không có sản phẩm'], 404);
        }

        foreach ($orderDetails as $orderDetail) {
            $product = $orderDetail->product;

            if (!$product) {
                continue; 
            }
            if ($product->quantity >= $orderDetail->quantity) {
                $product->quantity -= $orderDetail->quantity;

                $product->save();
            } else {
                return response()->json([
                    'error' => 'Số lượng trong kho không đủ cho sản phẩm: ' . $product->name,
                ], 400);
            }
        }

        return response()->json([
            'message' => 'Cập nhật số lượng sản phẩm trong kho thành công.',
        ], 200);
    }
}
