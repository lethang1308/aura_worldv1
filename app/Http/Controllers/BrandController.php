<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        // Tìm kiếm theo tên brand
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Sắp xếp theo ngày tạo mới nhất
        $query->orderBy('created_at', 'desc');

        $brands = $query->paginate(10);

        return view('admins.brands.brandlist', compact('brands'));
    }

    public function create()
    {
        return view('admins.brands.brandcreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ];
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = 'storage/' . $path;
        }
        Brand::create($data);
        return redirect()->route('brands.index')->with('success', 'Tạo thương hiệu mới thành công!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admins.brands.brandedit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);
        $brand = Brand::findOrFail($id);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ];
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('brands', 'public');
            $data['logo'] = 'storage/' . $path;
        }
        $brand->update($data);
        return redirect()->route('brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = 'inactive';
        $brand->save();
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Xóa thương hiệu thành công!');
    }

    public function restore($id)
    {
        $brand = Brand::withTrashed()->findOrFail($id);
        $brand->restore();
        $brand->status = 'active';
        $brand->save();
        return redirect()->route('brands.index')->with('success', 'Khôi phục thương hiệu thành công!');
    }

    public function trash()
    {
        $brands = Brand::onlyTrashed()->get();
        return view('admins.brands.brandlist', compact('brands'))->with('trash', true);
    }
}
