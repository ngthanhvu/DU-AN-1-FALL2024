<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    /**
     * Tạo mã giảm giá mới
     */
    public function createDiscount(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:discounts,code', 
            'value' => 'required|numeric|min:0', 
            'type' => 'required|in:percentage,fixed', 
            'expires_at' => 'nullable|date|after:today', 
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        try {
            $discount = Discount::create([
                'code' => $validatedData['code'],
                'value' => $validatedData['value'],
                'type' => $validatedData['type'],
                'expires_at' => $validatedData['expires_at'],
                'usage_limit' => $validatedData['usage_limit'] ?? null, 
                'used_count' => 0, 
            ]);
            return response()->json([
                'message' => 'Thêm mã giảm giá thành công',
                'discount' => $discount
            ], 201);
        } catch (\Exception $e) {
            Log::error("Error creating discount: " . $e->getMessage());
            return response()->json([
                'message' => 'Thêm mã giảm giá thất bại',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    /**
     * Lấy danh sách mã giảm giá
     */
    public function getDiscounts()
    {
        $discounts = Discount::all();
        return response()->json($discounts, 200);
    }

    /**
     * Áp dụng mã giảm giá
     */
    public function applyDiscount(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|exists:discounts,code', 
            'total_amount' => 'required|numeric|min:0', 
        ]);
        $discount = Discount::where('code', $validatedData['code'])
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            })
            ->first();
        if (!$discount) {
            return response()->json(['message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn'], 422);
        }
        $discountValue = $discount->type === 'percentage'
            ? ($validatedData['total_amount'] * ($discount->value / 100))
            : $discount->value; 
        $discountValue = min($discountValue, $validatedData['total_amount']);
        $discount->increment('used_count');
        return response()->json([
            'success' => true,
            'discount_value' => $discountValue,
            'final_amount' => $validatedData['total_amount'] - $discountValue,
        ], 200);
    }


    /**
     * Xóa mã giảm giá
     */
    public function deleteDiscount($id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Không thể xóa mã giảm giá "404"'], 404);
        }

        $discount->delete();

        return response()->json(['message' => 'Xóa mã giảm giá thành công'], 200);
    }
    /**
     * Sửa mã giảm giá
     */
    public function update(Request $request, $id)
    {
        $discount = Discount::find($id);

        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'value' => 'required|numeric',
            'type' => 'required|string|in:percentage,fixed',
            'expires_at' => 'nullable|date',
            'usage_limit' => 'nullable|numeric',
        ]);

        $discount->update($validated);

        return response()->json(['message' => 'Cập nhật mã giảm giá thành công', 'discount' => $discount]);
    }
}
