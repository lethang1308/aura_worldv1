<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->latest()->get();
        return view('admins.attributevalues.attributevaluelist', compact('attributeValues'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('admins.attributevalues.attributevaluecreate', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        AttributeValue::create($request->only('attribute_id', 'value'));

        return redirect()->route('attributeValues.list')->with('success', 'Đã thêm giá trị thuộc tính!');
    }

    public function edit($id)
    {
        $value = AttributeValue::findOrFail($id);
        $attributes = Attribute::all();
        return view('admins.attributevalues.attributevalueedit', compact('value', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $value = AttributeValue::findOrFail($id);
        $value->update($request->only('attribute_id', 'value'));

        return redirect()->route('attributeValues.list')->with('success', 'Đã cập nhật thành công!');
    }

    public function destroy($id)
    {
        $value = AttributeValue::findOrFail($id);
        $value->delete();
        return redirect()->route('attributeValues.list')->with('success', 'Đã xóa thành công!');
    }

    public function restore($id)
    {
        $value = AttributeValue::withTrashed()->findOrFail($id);
        $value->restore();
        return redirect()->route('attributeValues.list')->with('success', 'Đã khôi phục thành công!');
    }

    public function trash()
    {
        $attributeValues = AttributeValue::onlyTrashed()->get();
        return view('admins.attributevalues.attributevaluelist', compact('attributeValues'))->with('trash', true);
    }
}
