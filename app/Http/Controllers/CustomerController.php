<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index(Request $request)
    {
        $query = User::where('role_id', 2);

        // Tìm kiếm theo từ khóa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%');
            });
        }

        $customers = $query->latest()->paginate(10);

        // Giữ lại các tham số tìm kiếm trong phân trang
        $customers->appends($request->query());

        return view('admins.customers.customerlist', compact('customers'));
    }

    // Hiển thị thông tin chi tiết của 1 khách hàng
    public function show($id) {}

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $customer = User::where('role_id', 2)->findOrFail($id);
        return view('admins.customers.customeredit', compact('customer'));
    }

    // Xử lý cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        // Chỉ tìm user role_id = 2 (khách hàng)
        $customer = User::where('role_id', 2)->findOrFail($id);

        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        // Cập nhật thông tin
        $customer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        // Chuyển hướng về danh sách với thông báo
        return redirect()->route('customers.index')->with('success', 'Cập nhật khách hàng thành công!');
    }


    // Xóa khách hàng
    public function destroy($id)
    {
        $customer = User::where('role_id', 2)->findOrFail($id);
        $customer->is_active = 0;
        $customer->save();
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function restore($id)
    {
        $customer = User::withTrashed()->where('role_id', 2)->findOrFail($id);
        $customer->restore();
        $customer->is_active = 1;
        $customer->save();
        return redirect()->route('customers.index')->with('success', 'Customer restored successfully.');
    }

    public function trash()
    {
        $customers = User::onlyTrashed()->where('role_id', 2)->paginate(10);
        return view('admins.customers.customerlist', compact('customers'))->with('trash', true);
    }
}
