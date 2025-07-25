<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $products = Product::orderBy('name')->pluck('name', 'id'); // id => name

        $query = ProductImage::with('product')->latest();

        if ($productId = $request->input('product_id')) {
            $query->where('product_id', $productId);
        }

        $images = $query->paginate(8)->withQueryString();

        return view('admins.images.imageslist', compact('images', 'products'));
    }
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        // Nếu ảnh bị xoá là ảnh nổi bật
        if ($image->is_featured) {
            // Tìm ảnh khác cùng sản phẩm để thay thế làm ảnh nổi bật
            $nextImage = ProductImage::where('product_id', $productId)
                ->where('id', '!=', $image->id)
                ->first();

            if ($nextImage) {
                $nextImage->update(['is_featured' => 1]);
            }
        }

        // Xoá ảnh khỏi storage và DB
        \Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Ảnh đã được xoá.');
    }
}
