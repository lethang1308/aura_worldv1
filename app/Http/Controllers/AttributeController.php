<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AttributeController extends Controller
{
    // 1. Danh sách thuộc tính
    public function index()
    {
        // Lấy tất cả thuộc tính kèm theo các giá trị (dùng eager loading)
        $attributes = Attribute::with('attributeValues')->latest()->get();

        // Trả về view và truyền dữ liệu attributes
        return view('admins.attributes.attributelist', compact('attributes'));
    }

    // 2. Hiển thị form tạo mới
    public function create()
    {
        // Trả về view 'admin.attributes.create'
        return view('admins.attributes.attributecreate');
    }

    // 3. Lưu thuộc tính mới
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
        ], [
            'name.required' => 'Tên thuộc tính không được để trống.',
            'name.string' => 'Tên thuộc tính phải là chuỗi ký tự.',
            'name.max' => 'Tên thuộc tính tối đa 255 ký tự.',
            'values.required' => 'Phải nhập ít nhất một giá trị cho thuộc tính.',
            'values.array' => 'Giá trị thuộc tính phải là mảng.',
            'values.min' => 'Phải nhập ít nhất một giá trị cho thuộc tính.',
            'values.*.required' => 'Giá trị thuộc tính không được để trống.',
            'values.*.string' => 'Giá trị thuộc tính phải là chuỗi ký tự.',
            'values.*.max' => 'Giá trị thuộc tính tối đa 255 ký tự.',
        ]);

        // Tạo mới thuộc tính
        $attribute = Attribute::create([
            'name' => $request->name,
        ]);

        // Tạo các attribute value nếu có
        if ($request->has('values')) {
            foreach ($request->values as $value) {
                $attribute->attributeValues()->create([
                    'value' => $value,
                ]);
            }
        }

        // Redirect về danh sách với thông báo thành công
        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được tạo thành công!');
    }

    // 4. Hiển thị form chỉnh sửa thuộc tính
    public function edit($id)
    {
    // Tìm attribute theo id (hoặc trả về 404 nếu không tồn tại)
    $attribute = Attribute::findOrFail($id);
    // Lấy các giá trị thuộc tính liên quan
    $attributeValues = $attribute->attributeValues()->get();
    // Trả về view chỉnh sửa và truyền dữ liệu attribute, attributeValues vào
    return view('admins.attributes.attributeedit', compact('attribute', 'attributeValues'));
    }



    // 5. Cập nhật thuộc tính
    public function update(Request $request, $id)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'values' => 'array',
            'values.*' => 'nullable|string|max:255',
            'new_values' => 'array',
            'new_values.*' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Tên thuộc tính không được để trống.',
            'name.string' => 'Tên thuộc tính phải là chuỗi ký tự.',
            'name.max' => 'Tên thuộc tính tối đa 255 ký tự.',
            'values.*.max' => 'Giá trị thuộc tính tối đa 255 ký tự.',
            'new_values.*.max' => 'Giá trị thuộc tính tối đa 255 ký tự.',
        ]);

        // 2. Tìm attribute theo ID
        $attribute = Attribute::findOrFail($id);

        // 3. Cập nhật thuộc tính
        $attribute->update([
            'name' => $request->name,
        ]);

        // 4. Cập nhật các giá trị thuộc tính hiện có
        $currentValueIds = $attribute->attributeValues()->pluck('id')->toArray();
        $requestValueIds = $request->has('values') ? array_keys($request->values) : [];

        // Sửa giá trị
        if ($request->has('values')) {
            foreach ($request->values as $id => $value) {
                $attribute->attributeValues()->where('id', $id)->update(['value' => $value]);
            }
        }

        // Xóa giá trị bị xóa (nếu id không còn trong request)
        $idsToDelete = array_diff($currentValueIds, $requestValueIds);
        if (!empty($idsToDelete)) {
            $attribute->attributeValues()->whereIn('id', $idsToDelete)->delete();
        }

        // Thêm giá trị mới
        if ($request->has('new_values')) {
            foreach ($request->new_values as $newValue) {
                if ($newValue !== null && $newValue !== '') {
                    $attribute->attributeValues()->create(['value' => $newValue]);
                }
            }
        }

        // 5. Redirect kèm thông báo
        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được cập nhật thành công!');
    }


    // 6. Xoá thuộc tính
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        if ($attribute->attributeValues()->exists()) {
            $attribute->attributeValues()->delete();
        }
        $attribute->delete();
        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được xóa thành công!');
    }

    public function restore($id)
    {
        $attribute = Attribute::withTrashed()->findOrFail($id);
        $attribute->restore();
        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được khôi phục thành công!');
    }

    public function trash()
    {
        $attributes = Attribute::onlyTrashed()->get();
        return view('admins.attributes.attributelist', compact('attributes'))->with('trash', true);
    }
}
