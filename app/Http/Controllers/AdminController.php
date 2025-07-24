<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $admins = User::where('role_id', 1)->paginate(10);
        return view('admins.admin.adminlist', compact('admins'));
    }

    // Hiển thị form cập nhật profile cho admin
    public function showProfile()
    {
        $admin = Auth::user();
        if (!$admin) {
            return redirect()->route('login');
        }
        return view('admins.admin.profile', compact('admin'));
    }

    // Xử lý cập nhật profile cho admin
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();
        if (!$admin) {
            return redirect()->route('login');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $admin->avatar = $avatarPath;
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->save();
        return redirect()->route('admin.profile')->with('success', 'Cập nhật thành công!');
    }
}
