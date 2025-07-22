<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Attribute;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    private Brand $brand;

    private Category $category;

    private Product $product;

    private Variant $variant;

    private Attribute $attribute;

    private AttributeValue $attributeValue;
    public function __construct()
    {
        $this->brand = new Brand();
        $this->category = new Category();
        $this->product = new Product();
        $this->variant = new Variant();
        $this->attribute = new Attribute();
        $this->attributeValue = new AttributeValue();
    }
    public function home()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::all();
        return view('clients.layouts.home', compact('brands', 'categories', 'products'));
    }

    public function index(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $attributeValues = AttributeValue::all();

        $query = Product::query();

        // ✅ Nếu có category đơn lẻ (từ menu), convert thành mảng categories[]
        if ($request->filled('category')) {
            $request->merge([
                'categories' => [$request->category]
            ]);
        }

        // ✅ Nếu có brand đơn lẻ (từ menu), convert thành mảng brands[]
        if ($request->filled('brand')) {
            $request->merge([
                'brands' => [$request->brand]
            ]);
        }

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // ✅ Lọc theo nhiều danh mục (cả cha và con)
        if ($request->has('categories') && is_array($request->categories)) {
            $allCategoryIds = [];

            foreach ($request->categories as $catId) {
                $category = Category::find($catId);
                if ($category) {
                    if (is_null($category->parent_category_id)) {
                        $childIds = Category::where('parent_category_id', $category->id)->pluck('id')->toArray();
                        $allCategoryIds = array_merge($allCategoryIds, [$category->id], $childIds);
                    } else {
                        $allCategoryIds[] = $category->id;
                    }
                }
            }

            if (!empty($allCategoryIds)) {
                $query->whereIn('category_id', $allCategoryIds);
            }
        }

        // ✅ Lọc theo nhiều thương hiệu
        if ($request->has('brands') && is_array($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }

        if ($request->has('attribute_value_ids') && is_array($request->attribute_value_ids)) {
            $query->whereHas('variants.attributeValues', function ($q) use ($request) {
                $q->whereIn('attributes_values.id', $request->attribute_value_ids); // 👈 bảng đúng
            });
        }


        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Phân trang sản phẩm kèm ảnh đại diện
        $products = $query->with('featuredImage')->paginate(9);

        // Trả về view
        return view('clients.products.productlist', compact(
            'brands',
            'categories',
            'products',
            'attributeValues'
        ));
    }

    public function showProduct($id)
    {
        $product = Product::with([
            'images',
            'featuredImage',
            'variants.attributeValues.attribute' // để lấy được cả tên attribute (VD: "Dung tích")
        ])->findOrFail($id);

        $categories = Category::all();
        $brands = Brand::all();

        // Trích xuất các giá trị thuộc tính gắn với sản phẩm qua variant
        $attributeValues = $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues->map(function ($value) use ($variant) {
                    return [
                        'id' => $value->id,
                        'value' => $value->value,
                        'attribute_name' => $value->attribute->name ?? '',
                        'variant_id' => $variant->id,
                        'price' => $variant->price,
                    ];
                });
            })->unique('id')->values();

        return view('clients.products.productdetail', compact(
            'product',
            'categories',
            'brands',
            'attributeValues'
        ));
    }


    public function showAllBrand()
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('clients.brands.brandlist', compact('brands', 'categories'));
    }

    public function viewCart()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        }
        $cart = Cart::with(['cartItem.variant.product.images'])->where('user_id', $user->id)->first();

        return view('clients.carts.cartlist', compact('brands', 'categories', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:variants,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        }
        $variant = Variant::findOrFail($request->variant_id);

        // 1. Tìm hoặc tạo cart cho user hiện tại
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 2. Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('variant_id', $variant->id)
            ->first();

        if ($cartItem) {
            // Nếu đã có → tăng số lượng
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có → tạo mới
            CartItem::create([
                'cart_id'    => $cart->id,
                'variant_id' => $variant->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($itemId);
        $item->quantity = $request->quantity;
        $item->save();

        // Tính lại tổng giá trị đơn hàng
        $price = $item->variant->price ?? $item->variant->product->base_price;
        $total = $price * $item->quantity;
        $subtotal = $item->cart->cartItem->sum(function ($ci) {
            $price = $ci->variant->price ?? $ci->variant->product->base_price;
            return $price * $ci->quantity;
        });

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'subtotal' => number_format($subtotal, 2),
        ]);
    }

    public function deleteProduct($itemId)
    {
        $item = CartItem::findOrFail($itemId);

        if (auth()->id() !== $item->cart->user_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xoá sản phẩm này.');
        }

        $item->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $brands = Brand::all();
        $categories = Category::all();
        return view('clients.profiles.profile', compact('user', 'brands', 'categories'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        try {
            $user->update($validated);

            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại!');
        }
    }
}
