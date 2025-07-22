<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Variant;
use App\Models\product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Lưu review
    public function store(Request $request, $product_id)
    {
        $user = Auth::user();
        $product = product::findOrFail($product_id);

        // Kiểm tra đã mua sản phẩm chưa
        $hasPurchased = OrderDetail::whereHas('order', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereHas('variant', function($q) use ($product_id) {
            $q->where('product_id', $product_id);
        })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua!');
        }

        // Kiểm tra đã review chưa
        $reviewed = Review::where('user_id', $user->id)->where('product_id', $product_id)->exists();
        if ($reviewed) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá 1 lần cho mỗi sản phẩm!');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    // Hiển thị danh sách review của sản phẩm
    public function show($product_id)
    {
        $product = product::findOrFail($product_id);
        $reviews = $product->reviews()->with('user')->latest()->get();
        $average = $product->reviews()->avg('rating');
        return view('products.reviews', compact('product', 'reviews', 'average'));
    }

    // Hiển thị danh sách review cho admin
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();
        return view('admins.reviews.reviewlist', compact('reviews'));
    }

    // Hiển thị form sửa review
    public function edit($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admins.reviews.reviewedit', compact('review'));
    }

    // Cập nhật review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return redirect()->route('admin.reviews.list')->with('success', 'Cập nhật đánh giá thành công!');
    }

    // Xóa review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews.list')->with('success', 'Xóa đánh giá thành công!');
    }
}
