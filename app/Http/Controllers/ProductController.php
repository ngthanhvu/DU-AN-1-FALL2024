<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Skus;
use App\Models\Category;
use App\Models\Images;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'skus', 'images')->get();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'sku_code' => 'required',
            'images' => 'required|array', // Đảm bảo có ảnh
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh
            'primary_image' => 'required|integer' // Thêm trường primary_image để chỉ định ảnh chính
        ]);

        // Tạo product
        $product = Product::create($request->only('name', 'description', 'price', 'quantity', 'category_id'));

        // Tạo SKU
        $product->skus()->create($request->only('sku_code', 'size', 'color', 'stock'));

        // Lưu hình ảnh và chỉ định ảnh chính
        $primaryImageId = $request->primary_image; // Lấy ID ảnh chính từ form

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('images', 'public');
                $isPrimary = ($index == $primaryImageId) ? 1 : 0; // Kiểm tra ảnh có phải là ảnh chính không

                // Lưu ảnh vào DB
                Images::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return response()->json($product->load('category', 'skus', 'images'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('category', 'skus', 'images'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'sku_id' => 'sometimes|exists:skus,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cập nhật product
        $product->update($request->all());

        // Upload hình ảnh mới nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return response()->json($product->load('category', 'skus', 'images'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Xóa các hình ảnh liên quan
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Xóa product
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 204);
    }
}
