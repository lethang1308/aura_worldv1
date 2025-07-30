<?php

/**
 * Script test nhanh hệ thống banner
 * Chạy: php test_banner_system.php
 */

require_once 'vendor/autoload.php';

use App\Models\Banner;

echo "=== TEST HỆ THỐNG BANNER ===\n\n";

try {
    // 1. Kiểm tra banner chính
    echo "1. Banner chính (Carousel):\n";
    $mainBanners = Banner::active()->main()->ordered()->get();
    echo "   - Số lượng: " . $mainBanners->count() . "\n";
    foreach ($mainBanners as $banner) {
        echo "   - " . $banner->title . " (ID: " . $banner->id . ")\n";
    }

    // 2. Kiểm tra banner phụ
    echo "\n2. Banner phụ (Card):\n";
    $secondaryBanners = Banner::active()->secondary()->ordered()->limit(2)->get();
    echo "   - Số lượng: " . $secondaryBanners->count() . "\n";
    foreach ($secondaryBanners as $banner) {
        echo "   - " . $banner->title . " (ID: " . $banner->id . ")\n";
    }

    // 3. Kiểm tra tổng quan
    echo "\n3. Tổng quan:\n";
    $totalBanners = Banner::count();
    $activeBanners = Banner::active()->count();
    echo "   - Tổng số banner: " . $totalBanners . "\n";
    echo "   - Banner active: " . $activeBanners . "\n";
    echo "   - Banner inactive: " . ($totalBanners - $activeBanners) . "\n";

    // 4. Kiểm tra routes
    echo "\n4. Kiểm tra routes:\n";
    $routes = [
        'banners.index' => '/admin/banners',
        'banners.create' => '/admin/banners/create',
    ];

    foreach ($routes as $name => $path) {
        try {
            $url = route($name);
            echo "   ✅ " . $name . " -> " . $path . "\n";
        } catch (Exception $e) {
            echo "   ❌ " . $name . " -> " . $path . " (Lỗi: " . $e->getMessage() . ")\n";
        }
    }

    echo "\n=== KẾT QUẢ TEST ===\n";
    if ($mainBanners->count() > 0 && $secondaryBanners->count() > 0) {
        echo "✅ Hệ thống banner hoạt động tốt!\n";
        echo "   - Có " . $mainBanners->count() . " banner chính\n";
        echo "   - Có " . $secondaryBanners->count() . " banner phụ\n";
    } else {
        echo "⚠️  Hệ thống cần kiểm tra:\n";
        if ($mainBanners->count() == 0) {
            echo "   - Chưa có banner chính\n";
        }
        if ($secondaryBanners->count() == 0) {
            echo "   - Chưa có banner phụ\n";
        }
        echo "   Chạy: php setup_banner_system.php để setup\n";
    }

} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "\n";
    echo "Kiểm tra kết nối database và chạy migration\n";
} 