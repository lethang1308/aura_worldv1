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
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'logo_file.image' => 'File phải là hình ảnh.',
            'logo_file.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'logo_file.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            // Kiểm tra xem tên thương hiệu đã tồn tại chưa
            $existingBrand = Brand::where('name', $validated['name'])->first();
            
            if ($existingBrand) {
                return back()->with('error', 'Tên thương hiệu đã tồn tại.')->withInput();
            }

            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ];
            
            if ($request->hasFile('logo_file')) {
                $path = $request->file('logo_file')->store('brands', 'public');
                $data['logo'] = 'storage/' . $path;
            }
            
            Brand::create($data);
            return redirect()->route('brands.index')->with('success', 'Tạo thương hiệu mới thành công!');
        } catch (\Exception $e) {
            \Log::error('Brand creation error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo thương hiệu: ' . $e->getMessage())->withInput();
        }
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
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'logo_file.image' => 'File phải là hình ảnh.',
            'logo_file.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'logo_file.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        try {
            $brand = Brand::findOrFail($id);
            
            // Kiểm tra xem tên thương hiệu đã tồn tại chưa (trừ thương hiệu hiện tại)
            $existingBrand = Brand::where('name', $validated['name'])
                ->where('id', '!=', $id)
                ->first();
            
            if ($existingBrand) {
                return back()->with('error', 'Tên thương hiệu đã tồn tại.')->withInput();
            }

            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ];
            
            if ($request->hasFile('logo_file')) {
                // Xóa logo cũ nếu có
                if ($brand->logo && \Storage::disk('public')->exists(str_replace('storage/', '', $brand->logo))) {
                    \Storage::disk('public')->delete(str_replace('storage/', '', $brand->logo));
                }
                
                $path = $request->file('logo_file')->store('brands', 'public');
                $data['logo'] = 'storage/' . $path;
            }
            
            $brand->update($data);
            return redirect()->route('brands.index')->with('success', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            \Log::error('Brand update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật thương hiệu: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            
            // Kiểm tra xem có sản phẩm nào thuộc thương hiệu này không
            $hasProducts = \App\Models\Product::where('brand_id', $brand->id)->exists();
            
            if ($hasProducts) {
                return redirect()->back()->with('error', 'Không thể xóa thương hiệu vì đã có sản phẩm thuộc thương hiệu này!');
            }
            
            // Xóa logo nếu có
            if ($brand->logo && \Storage::disk('public')->exists(str_replace('storage/', '', $brand->logo))) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $brand->logo));
            }
            
            $brand->status = 'inactive';
            $brand->save();
            $brand->delete();
            
            return redirect()->route('brands.index')->with('success', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            \Log::error('Brand deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa thương hiệu: ' . $e->getMessage());
        }
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
        $brands = Brand::onlyTrashed()->paginate(10);
        return view('admins.brands.brandlist', compact('brands'))->with('trash', true);
    }
}
