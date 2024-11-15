<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'skus', 'images')->get();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu gửi lên
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'skus' => 'required|array',
            'skus.*.sku_code' => 'required|string',
            'skus.*.size' => 'nullable|string',
            'skus.*.color' => 'nullable|string',
            'skus.*.stock' => 'required|integer|min:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'required|integer|min:0',
        ]);

        // Tạo Product
        $product = Product::create($request->only('name', 'description', 'price', 'quantity', 'category_id'));

        // Tạo các SKU cho product
        foreach ($request->input('skus', []) as $sku) {
            $product->skus()->create([
                'sku_code' => $sku['sku_code'],
                'size' => $sku['size'] ?? null,
                'color' => $sku['color'] ?? null,
                'stock' => $sku['stock'] ?? 0,
            ]);
        }

        // Lưu hình ảnh và chỉ định ảnh chính
        if ($request->hasFile('images')) {
            $primaryImageIndex = $request->input('primary_image');
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('images', 'public');
                $isPrimary = ($index === $primaryImageIndex) ? 1 : 0;

                // Lưu ảnh vào database
                Images::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        // Trả về response
        return response()->json($product->load('category', 'skus', 'images'), 201);
    }


    public function show(Product $product)
    {
        return response()->json($product->load('category', 'skus', 'images'), 200);
    }

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20048',
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
