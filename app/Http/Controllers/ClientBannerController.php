<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class ClientBannerController extends Controller
{
    /**
     * Lấy danh sách banner hoạt động
     */
    public function getActiveBanners()
    {
        $banners = Banner::active()->ordered()->get();
        return response()->json($banners);
    }

    /**
     * Lấy banner cho trang chủ
     */
    public function getHomeBanners()
    {
        $banners = Banner::active()->ordered()->limit(5)->get();
        return $banners;
    }

    /**
     * Hiển thị banner trong component
     */
    public function showBanners()
    {
        $banners = Banner::active()->ordered()->get();
        return view('clients.components.banners', compact('banners'));
    }
}
