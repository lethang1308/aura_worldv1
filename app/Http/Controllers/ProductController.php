<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with('category', 'featuredImage', 'brand');

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Tìm kiếm theo brand
        if ($request->filled('search_brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_brand . '%');
            });
        }

        // Tìm kiếm theo category
        if ($request->filled('search_category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_name', 'like', '%' . $request->search_category . '%');
            });
        }
        $query->orderBy('created_at', 'desc');
        $products = $query->paginate(6);

        // Lấy danh sách brands và categories để hiển thị trong dropdown
        $brands = Brand::orderBy('name')->get();
        $categories = Category::orderBy('category_name')->get();

        return view('admins.products.productlist', compact('products', 'brands', 'categories'));
    }

    // Hiển thị form tạo sản phẩm
    public function create()
    {
        $categories = Category::has('parent')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('admins.products.productcreate', compact('categories', 'brands'));
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['images', 'featuredImage'])->findOrFail($id);
        return view('admins.products.productdetail', compact('product'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Tạo sản phẩm
        $product = Product::create($validated);

        // Kiểm tra lại nếu có lỗi
        if (!$product || !$product->id) {
            return back()->with('error', 'Không thể tạo sản phẩm.');
        }

        // Xử lý lưu ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Lưu vào storage/app/public/products/images
                $path = $image->store('images/products', 'public');

                // Tạo bản ghi ảnh
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_featured' => $index === 0 ? 1 : 0, // Ảnh đầu tiên là nổi bật
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Tạo sản phẩm thành công!');
    }

    // Hiển thị form sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::has('parent')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('admins.products.productedit', compact('product', 'categories', 'brands'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer',
            'base_price' => 'required|numeric',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        // ✅ Cập nhật ảnh nổi bật
        if ($request->has('featured_image')) {
            foreach ($product->images as $image) {
                $image->update([
                    'is_featured' => $image->id == $request->featured_image ? 1 : 0
                ]);
            }
        }

        // ✅ Xử lý thêm ảnh mới nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('images/products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_featured' => 0, // Không tự động set nổi bật ảnh mới thêm
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }


    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
