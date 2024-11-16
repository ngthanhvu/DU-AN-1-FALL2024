<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_primary' => 'boolean',
        ]);

        if ($request->input('is_primary', false)) {
            Images::where('product_id', $request->product_id)->update(['is_primary' => 0]);
        }

        $imagePath = $request->file('image')->store('images', 'public');
        $image = Images::create([
            'product_id' => $request->product_id,
            'image_path' => $imagePath,
            'is_primary' => $request->input('is_primary', false),
        ]);

        return response()->json($image, 201);
    }


    public function destroy($id)
    {
        $image = Images::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
