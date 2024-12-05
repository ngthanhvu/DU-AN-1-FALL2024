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

        if ($review->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->review = $validated['review'];
        $review->rating = $validated['rating'];

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
        $query = Review::where('product_id', $productId)
            ->with(['user', 'product', 'replies.user']) // Bao gồm phản hồi và người dùng của phản hồi
            ->orderBy('created_at', 'desc');

        if ($request->has('rating')) {
            $rating = $request->input('rating');
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
            ->with(['user', 'product', 'replies.user']) // Bao gồm phản hồi và người dùng của phản hồi
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


    public function filterReviews(Request $request)
    {
        $query = Review::with(['user', 'product', 'replies.user']) // Bao gồm phản hồi và người dùng của phản hồi
            ->orderBy('created_at', 'desc');

        if ($request->has('category_id') && $request->input('category_id') !== null) {
            $categoryId = $request->input('category_id');

            $categoryExists = \App\Models\Category::find($categoryId);
            if (!$categoryExists) {
                return response()->json(['error' => 'Danh mục không hợp lệ.'], 400);
            }

            $query->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        if ($request->has('product_id') && $request->input('product_id') !== null) {
            $productId = $request->input('product_id');

            $productExists = \App\Models\Product::find($productId);
            if (!$productExists) {
                return response()->json(['error' => 'Sản phẩm không hợp lệ.'], 400);
            }

            $query->where('product_id', $productId);
        }

        $reviews = $query->paginate(5);

        return response()->json([
            'data' => $reviews->items(),
            'current_page' => $reviews->currentPage(),
            'last_page' => $reviews->lastPage(),
            'total' => $reviews->total(),
        ]);
    }
}
