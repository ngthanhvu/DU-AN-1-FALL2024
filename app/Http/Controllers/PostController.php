<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with('user')->get();
            return response()->json([
                'message' => 'Posts fetched successfully',
                'posts' => $posts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:10002',
                'user_id' => 'required|exists:users,id',
            ]);
            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('images', 'public');
            }
            $post = Post::create($validatedData);
            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $post = Post::with('user')->findOrFail($id);

            return response()->json([
                'message' => 'Post fetched successfully',
                'post' => $post
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getRelatedArticles($categoryId)
    {
        $relatedArticles = Post::where('category_id', $categoryId)->limit(3)->get();
        return response()->json(['articles' => $relatedArticles]);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Post $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:10002',
            ]);

            $post = Post::findOrFail($id);

            $post->update($request->only('title', 'content'));

            if ($request->hasFile('image')) {
                if ($post->image && Storage::exists('public/images/' . $post->image)) {
                    Storage::delete('public/images/' . $post->image);
                }

                // Lưu ảnh mới và cập nhật vào bài viết
                $imagePath = $request->file('image')->store('images', 'public');
                $post->update(['image' => $imagePath]);
            }

            return response()->json([
                'message' => 'Bài viết đã được cập nhật thành công',
                'post' => $post
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Không tìm thấy bài viết',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Không thể cập nhật bài viết',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post->image && Storage::exists('public/images/' . $post->image)) {
                Storage::delete('public/images/' . $post->image);
            }

            $post->delete();

            return response()->json([
                'message' => 'Xóa bài viết thành công',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Không tìm thấy bài viết',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Không thể xóa bài viết',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
