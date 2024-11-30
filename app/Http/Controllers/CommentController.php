<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $comment = Comment::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        return response()->json(['success' => true, 'comment' => $comment]);
    }
    public function getComments($productId)
    {
        $comments = Comment::where('product_id', $productId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($comments);
    }

}
