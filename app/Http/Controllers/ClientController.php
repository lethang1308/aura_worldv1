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
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('variant_id', $variant->id)
            ->first();

        $currentQuantityInCart = $cartItem ? $cartItem->quantity : 0;
        $newTotalQuantity = $currentQuantityInCart + $request->quantity;

        if ($newTotalQuantity > $variant->stock_quantity) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm vượt quá tồn kho. Chỉ còn ' . $variant->stock_quantity . ' sản phẩm.');
        }

        if ($cartItem) {
            $cartItem->quantity = $newTotalQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'variant_id' => $variant->id,
                'quantity'   => $request->quantity,
            ]);
        }

        // ✅ Cập nhật tổng số lượng và tổng tiền
        $cart->load('cartItem.variant.product');
        $this->updateCartTotals($cart);

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

        $cart = $item->cart->load('cartItem.variant.product');
        $this->updateCartTotals($cart); // ✅ cập nhật lại cart

        $price = $item->variant->price ?? $item->variant->product->base_price;
        $total = $price * $item->quantity;
        $subtotal = $cart->total_price;

        return response()->json([
            'success' => true,
            'total' => number_format($total, 2),
            'subtotal' => number_format($subtotal, 2),
        ]);
    }


    private function updateCartTotals(Cart $cart)
    {
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cart->cartItem as $item) {
            $price = $item->variant->price ?? $item->variant->product->base_price;
            $totalQuantity += $item->quantity;
            $totalPrice += $price * $item->quantity;
        }

        $cart->update([
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ]);
    }


    public function deleteProduct($itemId)
    {
        $item = CartItem::findOrFail($itemId);

        if (auth()->id() !== $item->cart->user_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xoá sản phẩm này.');
        }

        $cart = $item->cart;
        $item->delete();

        // ✅ load lại cart sau khi xoá để cập nhật
        $cart->load('cartItem.variant.product');
        $this->updateCartTotals($cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }


    public function viewCheckOut()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $cart = null;
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->with('cartItem.variant.product')->first();
        }
        return view('clients.carts.checkout', compact('brands', 'categories', 'cart'));
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

    public function showChangePasswordForm()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('clients.profiles.change', compact('brands', 'categories'));
    }

    // Xử lý đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    public function orderList()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('clients.orders.orderlist', compact('orders', 'categories', 'brands'));
    }

    public function orderDetail($id)
    {
        $user = Auth::user();
        $order = \App\Models\Order::with(['OrderDetail.variant.product.images'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        return view('clients.orders.orderdetail', compact('order', 'categories', 'brands'));
    }

    public function cancelOrder($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        if ($order->status_order !== 'pending') {
            return redirect()->route('client.orders')->with('error', 'Chỉ có thể hủy đơn hàng đang chờ xác nhận.');
        }
        $order->status_order = 'cancelled';
        $order->cancel_reason = 'Khách tự hủy';
        $order->save();
        return redirect()->route('client.orders')->with('success', 'Đã hủy đơn hàng thành công.');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'email' => 'required|email',
            'add1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,vnpay',
            'accept_terms' => 'accepted',
        ], [
            'accept_terms.accepted' => 'Bạn phải đồng ý với điều khoản dịch vụ.'
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('cartItem.variant')->first();

        if (!$cart || $cart->cartItem->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // ✅ Kiểm tra tồn kho cho từng item
        foreach ($cart->cartItem as $item) {
            $variant = $item->variant;
            if ($variant->stock_quantity < $item->quantity) {
                return redirect()->back()->with('error', 'Sản phẩm "' . ($variant->name ?? 'N/A') . '" không đủ số lượng tồn kho.');
            }
        }

        // ✅ Tính tổng tiền
        $subtotal = 0;
        foreach ($cart->cartItem as $item) {
            $subtotal += ($item->variant->price ?? 0) * $item->quantity;
        }
        $shipping = 50000;
        $totalPrice = $subtotal + $shipping;

        // ✅ Tạo đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'user_email' => $request->email,
            'user_phone' => $request->number,
            'user_address' => $request->add1 . ', ' . $request->city,
            'user_note' => $request->message,
            'status_order' => 'pending',
            'status_payment' => $request->payment_method === 'cod' ? 'unpaid' : 'pending',
            'type_payment' => $request->payment_method,
            'total_price' => $totalPrice,
        ]);

        // ✅ Trừ tồn kho nếu là COD
        if ($request->payment_method === 'cod') {
            foreach ($cart->cartItem as $item) {
                $variant = $item->variant;
                $variant->stock_quantity -= $item->quantity;
                $variant->save();

                app(\App\Http\Controllers\ProductController::class)->autoTrashIfOutOfStock($variant->product_id);
            }
        }

        // ✅ Lưu chi tiết đơn hàng
        foreach ($cart->cartItem as $item) {
            \App\Models\OrderDetail::create([
                'order_id' => $order->id,
                'variant_id' => $item->variant_id,
                'variant_price' => $item->variant->price ?? 0,
                'quantity' => $item->quantity,
                'total_price' => ($item->variant->price ?? 0) * $item->quantity,
            ]);
        }

        // ✅ Xoá giỏ hàng
        $cart->cartItem()->delete();
        $cart->delete();

        // ✅ Chuyển hướng VNPay nếu cần
        if ($request->payment_method === 'vnpay') {
            $vnpayService = new \App\Services\VNPayService();
            $paymentUrl = $vnpayService->createPaymentUrl(
                $order->id,
                $totalPrice,
                "Thanh toán đơn hàng #" . $order->id,
                $request->ip()
            );

            return redirect($paymentUrl);
        }

        return redirect()->route('client.carts')->with('success', 'Đặt hàng thành công! Đơn hàng của bạn đang chờ xác nhận.');
    }

    public function useCoupon(Request $request)
    {
        $code = $request->input('coupon_code');
        $coupon = Coupon::where('code', $code)->where('status', 1)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.']);
        }

        // Lấy giỏ hàng từ DB theo user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Bạn cần đăng nhập để sử dụng mã giảm giá.']);
        }

        $cart = Cart::with('cartItem.variant.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItem->isEmpty()) {
            return response()->json(['error' => 'Giỏ hàng trống.']);
        }

        $totalPrice = $cart->total_price;
        $discount = 0;

        if ($totalPrice < $coupon->min_order_value) {
            return response()->json(['error' => 'Đơn hàng chưa đạt giá trị tối thiểu để dùng mã.']);
        }

        if ($coupon->type == 'percent') {
            $discount = $totalPrice * ($coupon->value / 100);
        } elseif ($coupon->type == 'fixed') {
            $discount = $coupon->value;
        }

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = $coupon->max_discount;
        }

        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return response()->json([
            'success' => 'Áp dụng mã thành công!',
            'discount' => $discount,
            'formatted_discount' => number_format($discount, 0, ',', '.'),
            'total' => number_format($totalPrice + 50000 - $discount, 0, ',', '.')
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Bạn cần đăng nhập.']);
        }

        $cart = \App\Models\Cart::with('cartItem')->where('user_id', $user->id)->first();
        $total = ($cart->total_price ?? 0) + 50000;

        return response()->json([
            'success' => 'Đã huỷ mã giảm giá.',
            'discount' => 0,
            'formatted_discount' => number_format(0, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    public function addReview(Request $request, $id) // $id là product_id
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Kiểm tra xem user đã từng mua sản phẩm chưa
        $hasPurchased = Order::where('user_id', $user->id)
            ->whereIn('status_order', ['completed', 'received']) // các trạng thái đã nhận hàng
            ->whereHas('orderDetail.variant', function ($q) use ($id) {
                $q->where('product_id', $id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sau khi đã mua sản phẩm.');
        }

        // Kiểm tra nếu user đã đánh giá rồi thì không cho đánh giá lại (nếu muốn)
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        Review::create([
            'user_id'    => $user->id,
            'product_id' => $id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }
}
