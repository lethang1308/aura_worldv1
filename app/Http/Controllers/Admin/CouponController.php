<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();
        if ($request->filled('search_code')) {
            $query->where('code', 'like', '%' . $request->search_code . '%');
        }
        $query->orderBy('created_at', 'desc');
        $coupons = $query->paginate(10);
        return view('admins.coupons.couponlist', compact('coupons'));
    }

    public function create()
    {
        return view('admins.coupons.couponcreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);
        Coupon::create($validated);
        return redirect()->route('coupons.index')->with('success', 'Tạo phiếu giảm giá thành công!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admins.coupons.couponedit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
        ]);
        $coupon->update($validated);
        return redirect()->route('coupons.index')->with('success', 'Cập nhật phiếu giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = 'inactive';
        $coupon->save();
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Xóa phiếu giảm giá thành công!');
    }

    public function restore($id)
    {
        $coupon = Coupon::withTrashed()->findOrFail($id);
        $coupon->restore();
        $coupon->status = 'active';
        $coupon->save();
        return redirect()->route('coupons.index')->with('success', 'Khôi phục phiếu giảm giá thành công!');
    }

    public function trash()
    {
        $coupons = Coupon::onlyTrashed()->paginate(10);
        return view('admins.coupons.couponlist', compact('coupons'))->with('trash', true);
    }
}
