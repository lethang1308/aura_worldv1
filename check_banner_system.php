<?php

/**
 * Script kiểm tra hệ thống banner
 * Chạy: php check_banner_system.php
 */

require_once 'vendor/autoload.php';

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

echo "=== KIỂM TRA HỆ THỐNG BANNER ===\n\n";

// 1. Kiểm tra kết nối database
echo "1. Kiểm tra kết nối database...\n";
try {
    $banners = Banner::all();
    echo "✅ Kết nối database thành công\n";
    echo "   - Tổng số banner trong database: " . $banners->count() . "\n";
} catch (Exception $e) {
    echo "❌ Lỗi kết nối database: " . $e->getMessage() . "\n";
    exit(1);
}

// 2. Kiểm tra banner active
echo "\n2. Kiểm tra banner active...\n";
$activeBanners = Banner::active()->ordered()->get();
echo "   - Số banner active: " . $activeBanners->count() . "\n";

if ($activeBanners->count() > 0) {
    foreach ($activeBanners as $index => $banner) {
        echo "   - Banner " . ($index + 1) . ": " . $banner->title . " (ID: " . $banner->id . ")\n";
    }
} else {
    echo "   ⚠️  Không có banner nào active\n";
}

// 3. Kiểm tra storage
echo "\n3. Kiểm tra storage...\n";
$storagePath = storage_path('app/public');
$publicPath = public_path('storage');

if (File::exists($storagePath)) {
    echo "✅ Thư mục storage tồn tại: " . $storagePath . "\n";
} else {
    echo "❌ Thư mục storage không tồn tại\n";
}

if (File::exists($publicPath)) {
    echo "✅ Symbolic link storage tồn tại: " . $publicPath . "\n";
} else {
    echo "❌ Symbolic link storage không tồn tại\n";
    echo "   Chạy lệnh: php artisan storage:link\n";
}

// 4. Kiểm tra ảnh banner
echo "\n4. Kiểm tra ảnh banner...\n";
foreach ($activeBanners as $banner) {
    $imagePath = storage_path('app/public/' . $banner->image);
    if (File::exists($imagePath)) {
        echo "✅ Ảnh banner " . $banner->id . " tồn tại: " . $banner->image . "\n";
    } else {
        echo "❌ Ảnh banner " . $banner->id . " không tồn tại: " . $banner->image . "\n";
    }
}

// 5. Kiểm tra thư mục banners
echo "\n5. Kiểm tra thư mục banners...\n";
$bannersDir = storage_path('app/public/images/banners');
if (File::exists($bannersDir)) {
    echo "✅ Thư mục banners tồn tại: " . $bannersDir . "\n";
    $files = File::files($bannersDir);
    echo "   - Số file trong thư mục: " . count($files) . "\n";
} else {
    echo "❌ Thư mục banners không tồn tại\n";
    echo "   Tạo thư mục: " . $bannersDir . "\n";
}

// 6. Kiểm tra routes
echo "\n6. Kiểm tra routes...\n";
$routes = [
    'banners.index' => '/admin/banners',
    'banners.create' => '/admin/banners/create',
    'banners.store' => '/admin/banners (POST)',
];

foreach ($routes as $name => $path) {
    try {
        $url = route($name);
        echo "✅ Route " . $name . " tồn tại: " . $path . "\n";
    } catch (Exception $e) {
        echo "❌ Route " . $name . " không tồn tại: " . $path . "\n";
    }
}

// 7. Đề xuất khắc phục
echo "\n=== ĐỀ XUẤT KHẮC PHỤC ===\n";

if ($activeBanners->count() == 0) {
    echo "1. Chạy seeder để tạo banner mẫu:\n";
    echo "   php artisan db:seed --class=BannerSeeder\n\n";
}

if (!File::exists($publicPath)) {
    echo "2. Tạo symbolic link cho storage:\n";
    echo "   php artisan storage:link\n\n";
}

if (!File::exists($bannersDir)) {
    echo "3. Tạo thư mục banners:\n";
    echo "   mkdir -p " . $bannersDir . "\n\n";
}

echo "4. Kiểm tra quyền ghi file:\n";
echo "   chmod -R 755 " . storage_path('app/public') . "\n\n";

echo "5. Xóa cache nếu cần:\n";
echo "   php artisan cache:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan view:clear\n\n";

echo "=== HOÀN THÀNH KIỂM TRA ===\n"; 