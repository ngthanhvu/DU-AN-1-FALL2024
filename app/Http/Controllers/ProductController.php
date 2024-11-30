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

    public function view(Request $request)
    {
        $search = $request->input('search', '');

        $perPage = $request->input('per_page', 15);

        $categoryId = $request->input('category_id');

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Product::with('category', 'skus', 'images');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $products = $query->paginate($perPage);

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
            'skus.*.stock' => 'required|integer|min:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20048',
            'primary_image' => 'required|string',
        ]);

        $product = Product::create($request->only('name', 'description', 'price', 'quantity', 'category_id'));

        foreach ($request->input('skus', []) as $sku) {
            $product->skus()->create([
                'sku_code' => $sku['sku_code'],
                'size' => $sku['size'] ?? null,
                'stock' => $sku['stock'] ?? 0,
            ]);
        }

        $primaryImageName = $request->input('primary_image');

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $originalName = $image->getClientOriginalName();

                $isPrimary = ($originalName === $primaryImageName) ? 1 : 0;

                if ($isPrimary) {
                    Images::where('product_id', $product->id)->update(['is_primary' => 0]);
                }

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20048',
            'primary_image' => 'nullable|string',
        ]);


        $product->update($request->only('name', 'description', 'price', 'quantity', 'category_id'));

        if ($request->has('skus')) {
            $newSkuIds = collect($request->input('skus'))
                ->pluck('id')
                ->filter()
                ->toArray();

            $product->skus()
                ->whereNotIn('id', $newSkuIds)
                ->delete();

            foreach ($request->input('skus') as $skuData) {
                $product->skus()->updateOrCreate(
                    ['id' => $skuData['id'] ?? null],
                    [
                        'sku_code' => $skuData['sku_code'],
                        'size' => $skuData['size'] ?? null,
                        'stock' => $skuData['stock'] ?? 0,
                    ]
                );
            }
        }

        if ($request->has('primary_image')) {
            $primaryImagePath = $request->input('primary_image');

            Images::where('product_id', $product->id)->update(['is_primary' => 0]);

            Images::where('product_id', $product->id)
                ->where('image_path', $primaryImagePath)
                ->update(['is_primary' => 1]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $originalName = $image->getClientOriginalName();

                Images::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => 0,
                ]);
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
