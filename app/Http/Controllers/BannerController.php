<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        // Tìm kiếm theo title
        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        // Lọc theo status
        if ($request->filled('search_status')) {
            $query->where('status', $request->search_status);
        }

        $banners = $query->ordered()->paginate(10);

        return view('admins.banners.bannerlist', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.banners.bannercreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:main,secondary',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/banners', 'public');
            $validated['image'] = $path;
        }

        Banner::create($validated);

        return redirect()->route('banners.index')->with('success', 'Tạo banner thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admins.banners.bannerdetail', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admins.banners.banneredit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:main,secondary',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            
            $path = $request->file('image')->store('images/banners', 'public');
            $validated['image'] = $path;
        }

        $banner->update($validated);

        return redirect()->route('banners.index')->with('success', 'Cập nhật banner thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        // Xóa ảnh
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Xóa banner thành công!');
    }

    /**
     * Restore the specified resource from trash.
     */
    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('banners.trash')->with('success', 'Khôi phục banner thành công!');
    }

    /**
     * Display trash items.
     */
    public function trash()
    {
        $banners = Banner::onlyTrashed()->ordered()->paginate(10);
        return view('admins.banners.bannertrash', compact('banners'));
    }

    /**
     * Force delete the specified resource.
     */
    public function forceDelete($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        
        // Xóa ảnh
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->forceDelete();

        return redirect()->route('banners.trash')->with('success', 'Xóa vĩnh viễn banner thành công!');
    }
} 