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
            'value' => 'required|numeric|min:0|max:999999999',
            'min_order_value' => 'nullable|numeric|min:0|max:999999999',
            'max_discount' => 'nullable|numeric|min:0|max:999999999',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1|max:999999',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:500',
        ], [
            'code.required' => 'Mã coupon là bắt buộc.',
            'code.max' => 'Mã coupon không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã coupon đã tồn tại.',
            'type.required' => 'Loại giảm giá là bắt buộc.',
            'type.in' => 'Loại giảm giá không hợp lệ.',
            'value.required' => 'Giá trị giảm giá là bắt buộc.',
            'value.numeric' => 'Giá trị giảm giá phải là số.',
            'value.min' => 'Giá trị giảm giá không được âm.',
            'value.max' => 'Giá trị giảm giá quá lớn.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được âm.',
            'min_order_value.max' => 'Giá trị đơn hàng tối thiểu quá lớn.',
            'max_discount.numeric' => 'Giảm giá tối đa phải là số.',
            'max_discount.min' => 'Giảm giá tối đa không được âm.',
            'max_discount.max' => 'Giảm giá tối đa quá lớn.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'usage_limit.integer' => 'Giới hạn sử dụng phải là số nguyên.',
            'usage_limit.min' => 'Giới hạn sử dụng phải lớn hơn 0.',
            'usage_limit.max' => 'Giới hạn sử dụng quá lớn.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ]);

        try {
            Coupon::create($validated);
            return redirect()->route('coupons.index')->with('success', 'Tạo phiếu giảm giá thành công!');
        } catch (\Exception $e) {
            \Log::error('Coupon creation error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo phiếu giảm giá: ' . $e->getMessage())->withInput();
        }
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
            'value' => 'required|numeric|min:0|max:999999999',
            'min_order_value' => 'nullable|numeric|min:0|max:999999999',
            'max_discount' => 'nullable|numeric|min:0|max:999999999',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1|max:999999',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string|max:500',
        ], [
            'code.required' => 'Mã coupon là bắt buộc.',
            'code.max' => 'Mã coupon không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã coupon đã tồn tại.',
            'type.required' => 'Loại giảm giá là bắt buộc.',
            'type.in' => 'Loại giảm giá không hợp lệ.',
            'value.required' => 'Giá trị giảm giá là bắt buộc.',
            'value.numeric' => 'Giá trị giảm giá phải là số.',
            'value.min' => 'Giá trị giảm giá không được âm.',
            'value.max' => 'Giá trị giảm giá quá lớn.',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
            'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được âm.',
            'min_order_value.max' => 'Giá trị đơn hàng tối thiểu quá lớn.',
            'max_discount.numeric' => 'Giảm giá tối đa phải là số.',
            'max_discount.min' => 'Giảm giá tối đa không được âm.',
            'max_discount.max' => 'Giảm giá tối đa quá lớn.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'usage_limit.integer' => 'Giới hạn sử dụng phải là số nguyên.',
            'usage_limit.min' => 'Giới hạn sử dụng phải lớn hơn 0.',
            'usage_limit.max' => 'Giới hạn sử dụng quá lớn.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ]);

        try {
            $coupon->update($validated);
            return redirect()->route('coupons.index')->with('success', 'Cập nhật phiếu giảm giá thành công!');
        } catch (\Exception $e) {
            \Log::error('Coupon update error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật phiếu giảm giá: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            
            // Kiểm tra xem có đơn hàng nào sử dụng coupon này không
            $hasOrders = \App\Models\Order::where('coupon_code', $coupon->code)->exists();
            
            if ($hasOrders) {
                return redirect()->back()->with('error', 'Không thể xóa coupon vì đã có đơn hàng sử dụng!');
            }
            
            $coupon->status = 'inactive';
            $coupon->save();
            $coupon->delete();
            
            return redirect()->route('coupons.index')->with('success', 'Xóa phiếu giảm giá thành công!');
        } catch (\Exception $e) {
            \Log::error('Coupon deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa phiếu giảm giá: ' . $e->getMessage());
        }
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
