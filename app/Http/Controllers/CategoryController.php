<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    private category $category;

    public function __construct()
    {
        $this->category = new category();
    }

    public function index(Request $request)
    {
        $query = Category::with('parentCategory');

        // Tìm kiếm theo tên danh mục
        if ($request->filled('search_name')) {
            $query->where('category_name', 'like', '%' . $request->search_name . '%');
        }

        // Sắp xếp theo ngày tạo mới nhất
        $query->orderBy('created_at', 'desc');

        // Phân trang với 10 item mỗi trang, giữ lại tham số tìm kiếm
        $categories = $query->paginate(10)->appends(request()->query());

        return view('admins.categories.categorylist', compact('categories'));
    }

    // Hiển thị form tạo sản phẩm
    public function create()
    {
        $categories = Category::whereNull('parent_category_id')->get();
        return view('admins.categories.categorycreate', compact('categories'));
    }

    public function show($id) {}

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tên danh mục là bắt buộc.',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'parent_category_id.exists' => 'Danh mục cha không tồn tại.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            // Kiểm tra xem tên danh mục đã tồn tại chưa
            $existingCategory = Category::where('category_name', $validated['category_name'])
                ->where('parent_category_id', $validated['parent_category_id'])
                ->first();

            if ($existingCategory) {
                return back()->with('error', 'Tên danh mục đã tồn tại trong cùng cấp.')->withInput();
            }

            // Tạo danh mục mới
            Category::create([
                'category_name' => $validated['category_name'],
                'parent_category_id' => $validated['parent_category_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            // Redirect với thông báo thành công
            return redirect()->route('categories.index')
                ->with('success', 'Tạo danh mục mới thành công!');
        } catch (\Exception $e) {
            \Log::error('Category creation error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo danh mục: ' . $e->getMessage())->withInput();
        }
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_category_id')
            ->where('id', '!=', $id) // Tránh chọn chính nó làm danh mục cha
            ->get();
        return view('admins.categories.categoryedit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|integer|exists:categories,id|not_in:' . $id,
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tên danh mục là bắt buộc.',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'parent_category_id.exists' => 'Danh mục cha không tồn tại.',
            'parent_category_id.not_in' => 'Không thể chọn chính mình làm danh mục cha.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            $category = Category::findOrFail($id);

            // Kiểm tra xem tên danh mục đã tồn tại chưa (trừ danh mục hiện tại)
            $existingCategory = Category::where('category_name', $validated['category_name'])
                ->where('parent_category_id', $validated['parent_category_id'])
                ->where('id', '!=', $id)
                ->first();

            if ($existingCategory) {
                return back()->with('error', 'Tên danh mục đã tồn tại trong cùng cấp.')->withInput();
            }

            // Kiểm tra xem có tạo vòng lặp không
            if ($validated['parent_category_id']) {
                $parentId = $validated['parent_category_id'];
                $currentId = $id;
                
                // Kiểm tra xem parent có phải là con của current không
                $parent = Category::find($parentId);
                while ($parent && $parent->parent_category_id) {
                    if ($parent->parent_category_id == $currentId) {
                        return back()->with('error', 'Không thể tạo vòng lặp trong cấu trúc danh mục.')->withInput();
                    }
                    $parent = Category::find($parent->parent_category_id);
                }
            }

            $category->update([
                'category_name' => $validated['category_name'],
                'parent_category_id' => $validated['parent_category_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
        } catch (\Exception $e) {
            \Log::error('Category update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật danh mục: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            // Kiểm tra xem có danh mục con không
            if ($category->children()->count() > 0) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục cha đang có danh mục con!');
            }
            
            // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
            $hasProducts = \App\Models\Product::where('category_id', $category->id)->exists();
            
            if ($hasProducts) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục vì đã có sản phẩm thuộc danh mục này!');
            }
            
            // Kiểm tra xem có sản phẩm nào thuộc danh mục con không
            $childCategoryIds = $category->children()->pluck('id')->toArray();
            $hasProductsInChildren = \App\Models\Product::whereIn('category_id', $childCategoryIds)->exists();
            
            if ($hasProductsInChildren) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục vì đã có sản phẩm thuộc danh mục con!');
            }
            
            $category->status = 'inactive';
            $category->save();
            $category->delete();
            
            return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            \Log::error('Category deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        $category->status = 'active';
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Khôi phục danh mục thành công!');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(10);
        return view('admins.categories.categorylist', compact('categories'))->with('trash', true);
    }
}
