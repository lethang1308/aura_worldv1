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
            'description' => 'nullable|string|max:2000',
            'category_id' => 'required|integer|exists:categories,id',
            'base_price' => 'required|numeric|min:0|max:999999999',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'variants.attribute.*' => 'nullable|string|max:100',
            'variants.value.*' => 'nullable|string|max:100',
            'variants.price.*' => 'nullable|numeric|min:0|max:999999999',
            'variants.stock.*' => 'nullable|integer|min:0|max:999999',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'base_price.required' => 'Giá sản phẩm là bắt buộc.',
            'base_price.numeric' => 'Giá sản phẩm phải là số.',
            'base_price.min' => 'Giá sản phẩm không được âm.',
            'base_price.max' => 'Giá sản phẩm quá lớn.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'images.*.image' => 'File phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'variants.attribute.*.max' => 'Tên thuộc tính không được vượt quá 100 ký tự.',
            'variants.value.*.max' => 'Giá trị thuộc tính không được vượt quá 100 ký tự.',
            'variants.price.*.numeric' => 'Giá biến thể phải là số.',
            'variants.price.*.min' => 'Giá biến thể không được âm.',
            'variants.price.*.max' => 'Giá biến thể quá lớn.',
            'variants.stock.*.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'variants.stock.*.min' => 'Số lượng tồn kho không được âm.',
            'variants.stock.*.max' => 'Số lượng tồn kho quá lớn.',
        ]);

        try {
            // Tạo sản phẩm
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'base_price' => $validated['base_price'],
                'brand_id' => $validated['brand_id'],
                'status' => 'active',
            ]);

            // Kiểm tra lại nếu có lỗi
            if (!$product || !$product->id) {
                return back()->with('error', 'Không thể tạo sản phẩm.')->withInput();
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

            // Xử lý lưu biến thể (variants)
            if ($request->has('variants')) {
                $attributes = $request->input('variants.attribute', []);
                $values = $request->input('variants.value', []);
                $prices = $request->input('variants.price', []);
                $stocks = $request->input('variants.stock', []);

                foreach ($attributes as $i => $attributeName) {
                    $value = $values[$i] ?? null;
                    $price = $prices[$i] ?? null;
                    $stock = $stocks[$i] ?? null;
                    
                    if (!$attributeName || !$value) continue;

                    // Tìm hoặc tạo attribute
                    $attributeModel = \App\Models\Attribute::firstOrCreate(['name' => $attributeName]);
                    
                    // Tìm hoặc tạo attribute_value
                    $attributeValueModel = \App\Models\AttributeValue::firstOrCreate([
                        'attribute_id' => $attributeModel->id,
                        'value' => $value
                    ]);

                    // Tạo variant
                    $variant = \App\Models\Variant::create([
                        'product_id' => $product->id,
                        'price' => $price ?? $product->base_price,
                        'stock_quantity' => $stock ?? 0,
                        'status' => 'active',
                    ]);

                    // Gán attribute_value cho variant
                    $variant->attributeValues()->attach($attributeValueModel->id);
                }
            }

            return redirect()->route('products.index')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            \Log::error('Product creation error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo sản phẩm: ' . $e->getMessage())->withInput();
        }
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
            'description' => 'nullable|string|max:2000',
            'category_id' => 'required|integer|exists:categories,id',
            'base_price' => 'required|numeric|min:0|max:999999999',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'featured_image' => 'nullable|integer|exists:product_images,id',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'base_price.required' => 'Giá sản phẩm là bắt buộc.',
            'base_price.numeric' => 'Giá sản phẩm phải là số.',
            'base_price.min' => 'Giá sản phẩm không được âm.',
            'base_price.max' => 'Giá sản phẩm quá lớn.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'images.*.image' => 'File phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'featured_image.exists' => 'Hình ảnh nổi bật không tồn tại.',
        ]);

        try {
            $product = Product::findOrFail($id);
            
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'base_price' => $validated['base_price'],
                'brand_id' => $validated['brand_id'],
            ]);

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
        } catch (\Exception $e) {
            \Log::error('Product update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage())->withInput();
        }
    }


    // Xóa sản phẩm
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Kiểm tra xem sản phẩm có đơn hàng nào không
            $hasOrders = \App\Models\OrderDetail::whereHas('variant', function($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();
            
            if ($hasOrders) {
                return redirect()->route('products.index')->with('error', 'Không thể xóa sản phẩm vì đã có đơn hàng liên quan.');
            }
            
            // Xóa các variants trước
            $product->variants()->delete();
            
            // Xóa các hình ảnh
            foreach ($product->images as $image) {
                // Xóa file hình ảnh từ storage
                if (\Storage::disk('public')->exists($image->path)) {
                    \Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }
            
            // Xóa sản phẩm
            $product->status = 'inactive';
            $product->save();
            $product->delete();
            
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
        } catch (\Exception $e) {
            \Log::error('Product deletion error: ' . $e->getMessage());
            return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        $product->status = 'active';
        $product->save();
        return redirect()->route('products.index')->with('success', 'Khôi phục sản phẩm thành công!');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admins.products.productlist', compact('products'))->with('trash', true);
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('products.trash')->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }

    public function autoTrashIfOutOfStock($productId)
    {
        $product = Product::with('variants')->find($productId);

        if (!$product || $product->variants->isEmpty()) {
            return;
        }

        // Nếu tất cả biến thể đều hết hàng
        $allOutOfStock = $product->variants->every(function ($variant) {
            return $variant->stock_quantity <= 0;
        });

        if ($allOutOfStock) {
            $product->status = 'inactive';
            $product->save();
            $product->delete();
        }
    }
}
