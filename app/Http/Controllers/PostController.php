<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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
            $post = Post::with('user')->findOrFail($id); // Tìm bài viết với ID

            return response()->json([
                'message' => 'Post fetched successfully',
                'post' => $post  // Trả về bài viết với thông tin chi tiết
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
    // In your Laravel controller, for example
    public function getRelatedArticles($categoryId)
    {
        $relatedArticles = Post::where('category_id', $categoryId)->limit(3)->get();
        return response()->json(['articles' => $relatedArticles]);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
