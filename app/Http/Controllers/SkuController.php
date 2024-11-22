<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skus;

class SkuController extends Controller
{
    // Lấy tất cả SKU
    public function index()
    {
        return response()->json(Skus::all(), 200);
    }

    // Tạo mới SKU
    public function store(Request $request)
    {
        $request->validate([
            'sku_code' => 'required|string|unique:skus,sku_code',
            'size' => 'nullable|string',
            'stock' => 'required|integer',
        ]);

        $sku = Skus::create($request->only(['sku_code', 'size', 'stock']));

        return response()->json($sku, 201);
    }

    // Hiển thị thông tin một SKU
    public function show($id)
    {
        $sku = Skus::find($id);

        if (!$sku) {
            return response()->json(['message' => 'Skus not found'], 404);
        }

        return response()->json($sku, 200);
    }

    // Cập nhật SKU
    public function update(Request $request, $id)
    {
        $sku = Skus::find($id);

        if (!$sku) {
            return response()->json(['message' => 'Skus not found'], 404);
        }

        $sku->update($request->all());

        return response()->json($sku, 200);
    }

    // Xóa SKU
    public function destroy($id)
    {
        $sku = Skus::find($id);

        if (!$sku) {
            return response()->json(['message' => 'Skus not found'], 404);
        }

        $sku->delete();

        return response()->json(['message' => 'Skus deleted successfully'], 200);
    }
}
