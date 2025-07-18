<?php

namespace App\Http\Controllers;

use App\Models\User;


class AdminController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $admins = User::where('role_id', 1)->paginate(10);
        return view('admins.admin.adminlist', compact('admins'));
    }
}
