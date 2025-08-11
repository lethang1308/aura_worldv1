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
            'parent_category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'category_name.max' => 'Tên danh mục tối đa 255 ký tự.',
            'parent_category_id.exists' => 'Danh mục cha không hợp lệ.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

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
            'parent_category_id' => 'nullable|exists:categories,id|not_in:' . $id,
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ], [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'category_name.max' => 'Tên danh mục tối đa 255 ký tự.',
            'parent_category_id.exists' => 'Danh mục cha không hợp lệ.',
            'parent_category_id.not_in' => 'Không thể chọn chính nó làm danh mục cha.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'category_name' => $validated['category_name'],
            'parent_category_id' => $validated['parent_category_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục cha đang có danh mục con!');
        }
        $category->status = 'inactive';
        $category->save();
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
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
