<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\VariantAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariantController extends Controller
{
    /**
     * Hiển thị danh sách variants
     */
    public function index(Request $request)
    {
        $query = Variant::with(['product', 'attributesValue.attribute']);

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search_product')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_product . '%');
            });
        }

        // Tìm kiếm theo giá
        if ($request->filled('search_price_min')) {
            $query->where('price', '>=', $request->search_price_min);
        }

        if ($request->filled('search_price_max')) {
            $query->where('price', '<=', $request->search_price_max);
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        $variants = $query->orderBy('created_at', 'desc')->paginate(10);

        // Lấy danh sách sản phẩm để hiển thị trong dropdown
        $products = Product::orderBy('name')->get();

        return view('admins.variants.variantlist', compact('variants', 'products'));
    }

    /**
     * Hiển thị form tạo variant
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $attributes = Attribute::with('attributeValues')->get();
        
        return view('admins.variants.variantcreate', compact('products', 'attributes'));
    }

    /**
     * Hiển thị chi tiết variant
     */
    public function show($id)
    {
        $variant = Variant::with(['product', 'attributesValue.attribute'])->findOrFail($id);
        return view('admins.variants.variantdetail', compact('variant'));
    }

    /**
     * Lưu variant mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => 'exists:attributes_values,id',
        ]);

        try {
            DB::beginTransaction();

            // Tạo variant
            $variant = Variant::create([
                'product_id' => $validated['product_id'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'status' => $validated['status'],
            ]);

            // Lưu các attribute values
            foreach ($validated['attribute_values'] as $attributeValueId) {
                VariantAttribute::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $attributeValueId,
                ]);
            }

            DB::commit();

            return redirect()->route('variants.index')->with('success', 'Tạo variant thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể tạo variant: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form sửa variant
     */
    public function edit($id)
    {
        $variant = Variant::with(['product', 'attributesValue.attribute'])->findOrFail($id);
        $products = Product::orderBy('name')->get();
        $attributes = Attribute::with('attributeValues')->get();
        
        // Lấy các attribute value IDs đã chọn
        $selectedAttributeValues = $variant->attributesValue->pluck('id')->toArray();
        
        return view('admins.variants.variantedit', compact('variant', 'products', 'attributes', 'selectedAttributeValues'));
    }

    /**
     * Cập nhật variant
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => 'exists:attributes_values,id',
        ]);

        try {
            DB::beginTransaction();

            $variant = Variant::findOrFail($id);
            
            // Cập nhật thông tin variant
            $variant->update([
                'product_id' => $validated['product_id'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'status' => $validated['status'],
            ]);

            // Xóa các attribute values cũ
            VariantAttribute::where('variant_id', $variant->id)->delete();

            // Thêm các attribute values mới
            foreach ($validated['attribute_values'] as $attributeValueId) {
                VariantAttribute::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $attributeValueId,
                ]);
            }

            DB::commit();

            return redirect()->route('variants.index')->with('success', 'Cập nhật variant thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể cập nhật variant: ' . $e->getMessage());
        }
    }

    /**
     * Xóa variant
     */
    public function destroy($id)
    {
        try {
            $variant = Variant::findOrFail($id);
            
            // Xóa các variant attributes trước
            VariantAttribute::where('variant_id', $variant->id)->delete();
            
            // Xóa variant
            $variant->delete();
            
            return redirect()->route('variants.index')->with('success', 'Xóa variant thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa variant: ' . $e->getMessage());
        }
    }

    /**
     * Lấy attribute values theo product
     */
    public function getAttributeValuesByProduct($productId)
    {
        $product = Product::with('category')->findOrFail($productId);
        $attributes = Attribute::with('attributeValues')->get();
        
        return response()->json([
            'product' => $product,
            'attributes' => $attributes
        ]);
    }

    /**
     * Cập nhật trạng thái variant
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $variant = Variant::findOrFail($id);
        $variant->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }

    /**
     * Hiển thị thùng rác
     */
    public function trash()
    {
        $variants = Variant::onlyTrashed()
            ->with(['product', 'attributesValue.attribute'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('admins.variants.varianttrash', compact('variants'));
    }

    /**
     * Khôi phục variant từ thùng rác
     */
    public function restore($id)
    {
        $variant = Variant::onlyTrashed()->findOrFail($id);
        $variant->restore();

        return redirect()->route('variants.trash')->with('success', 'Khôi phục variant thành công!');
    }

    /**
     * Xóa vĩnh viễn variant
     */
    public function forceDelete($id)
    {
        try {
            $variant = Variant::onlyTrashed()->findOrFail($id);
            
            // Xóa các variant attributes
            VariantAttribute::where('variant_id', $variant->id)->delete();
            
            // Xóa vĩnh viễn variant
            $variant->forceDelete();
            
            return redirect()->route('variants.trash')->with('success', 'Xóa vĩnh viễn variant thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa vĩnh viễn variant: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị danh sách các giá trị thuộc tính của từng variant
     */
    public function variantValueList()
    {
        // Lấy tất cả variant cùng các attribute value liên quan
        $variants = \App\Models\Variant::with('attributesValue')->get();
        return view('admins.variants.variantvaluelist', compact('variants'));
    }
} 