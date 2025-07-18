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

    public function index()
    {
        $categories = Category::with('parentCategory')->get();
        return view('admins.categories.categorylist', compact('categories'));
    }

    // Hiển thị form tạo sản phẩm
    public function create()
    {
        $categories = Category::whereNull('parent_category_id')->get();
        return view('admins.categories.categorycreate', compact('categories'));
    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
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

        // Nếu là danh mục cha và có danh mục con, thì không cho xóa
        if ($category->children()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục cha đang có danh mục con!');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
