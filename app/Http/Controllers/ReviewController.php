<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Users;

class ReviewController extends Controller
{
    // Lấy tất cả các đánh giá (Reviews)
    public function index()
    {
        $reviews = Review::with(['user', 'product', 'replies.user'])->orderBy('created_at', 'desc')->get();
        return response()->json($reviews);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        if (!isset($validated['rating']) || $validated['rating'] < 1 || $validated['rating'] > 5) {
            return response()->json(['errors' => ['rating' => ['Bạn cần chọn số sao để đánh giá!']]], 400);
        }

        $review = new Review();
        $review->user_id = $validated['user_id'];
        $review->product_id = $validated['product_id'];
        $review->review = $validated['review'];
        $review->rating = $validated['rating'];

        // Lưu ảnh (nếu có)
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $review->image_path = $imagePath;
        }

        $review->save();

        return response()->json([
            'success' => true,
            'review' => $review,
            'message' => 'Đánh giá của bạn đã được gửi thành công!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $review = Review::findOrFail($id);

        // Kiểm tra quyền sở hữu
        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->review = $validated['review'];
        $review->rating = $validated['rating'];

        // Cập nhật ảnh (nếu có)
        if ($request->hasFile('image_path')) {
            if ($review->image_path && file_exists(public_path('storage/' . $review->image_path))) {
                unlink(public_path('storage/' . $review->image_path));
            }
            $imagePath = $request->file('image_path')->store('images', 'public');
            $review->image_path = $imagePath;
        }

        $review->save();

        return response()->json([
            'success' => true,
            'review' => $review,
            'message' => 'Cập nhật đánh giá thành công!',
        ]);
    }


    public function getReviewsByProduct(Request $request, $productId)
    {
        $query = Review::where('product_id', $productId)->with(['user', 'product'])->orderBy('created_at', 'desc');

        // Lọc theo rating nếu có tham số rating
        if ($request->has('rating')) {
            $rating = $request->input('rating');
            // Kiểm tra rating có hợp lệ không (từ 1 đến 5)
            if (in_array($rating, [1, 2, 3, 4, 5])) {
                $query->where('rating', $rating);
            } else {
                return response()->json(['error' => 'Rating không hợp lệ.'], 400);
            }
        }

        $reviews = $query->get();

        return response()->json($reviews);
    }



    public function deleteReview($reviewId)
    {
        $review = Review::find($reviewId);

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted successfully']);
    }

    public function like($reviewId)
    {
        $review = Review::find($reviewId);
        if ($review) {
            $review->likes += 1;
            $review->save();

            return response()->json($review, 200);
        }
        return response()->json(['error' => 'Review not found'], 404);
    }

    public function getReviewsByCategory($categoryId)
    {
        $reviews = Review::whereHas('product', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })
            ->with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }
    public function replyToReview(Request $request, $reviewId)
    {

        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
        ]);

        $reply = new Reply();
        $reply->user_id = $validated['user_id'];
        $reply->reply = $validated['reply'];
        $reply->review_id = $reviewId;
        $reply->save();

        return response()->json(['message' => 'Reply added successfully'], 200);
    }
    public function editReply(Request $request, $replyId)
    {
        $validated = $request->validate([
            'reply' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
        ]);

        // Tìm phản hồi để chỉnh sửa
        $reply = Reply::find($replyId);

        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }

        $user = Users::find($validated['user_id']);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->role !== 'admin' && $reply->user_id !== $validated['user_id']) {
            return response()->json(['message' => 'You do not have permission to edit this reply'], 403);
        }

        $reply->reply = $validated['reply'];
        $reply->save();

        return response()->json(['message' => 'Reply updated successfully'], 200);
    }
    public function deleteReply(Request $request, $replyId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $reply = Reply::find($replyId);

        if (!$reply) {
            return response()->json(['message' => 'Reply not found'], 404);
        }

        $user = Users::find($validated['user_id']);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->role !== 'admin' && $reply->user_id !== $validated['user_id']) {
            return response()->json(['message' => 'You do not have permission to delete this reply'], 403);
        }

        $reply->delete();

        return response()->json(['message' => 'Reply deleted successfully'], 200);
    }
}
