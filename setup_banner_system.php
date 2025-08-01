<?php

/**
 * Script setup hệ thống banner hoàn chỉnh
 * Chạy: php setup_banner_system.php
 */

echo "=== SETUP HỆ THỐNG BANNER HOÀN CHỈNH ===\n\n";

// 1. Chạy migration để thêm trường type
echo "1. Chạy migration để thêm trường type...\n";
$output = shell_exec('php artisan migrate --path=database/migrations/2025_01_15_000000_add_type_to_banners_table.php 2>&1');
echo $output;

// 2. Tạo symbolic link cho storage
echo "\n2. Tạo symbolic link cho storage...\n";
$output = shell_exec('php artisan storage:link 2>&1');
echo $output;

// 3. Tạo thư mục banners
echo "\n3. Tạo thư mục banners...\n";
$bannersDir = storage_path('app/public/images/banners');
if (!file_exists($bannersDir)) {
    mkdir($bannersDir, 0755, true);
    echo "✅ Đã tạo thư mục: " . $bannersDir . "\n";
} else {
    echo "✅ Thư mục đã tồn tại: " . $bannersDir . "\n";
}

// 4. Chạy seeder
echo "\n4. Chạy seeder để tạo banner mẫu...\n";
$output = shell_exec('php artisan db:seed --class=BannerSeeder 2>&1');
echo $output;

// 5. Xóa cache
echo "\n5. Xóa cache...\n";
$output = shell_exec('php artisan cache:clear 2>&1');
echo $output;
$output = shell_exec('php artisan config:clear 2>&1');
echo $output;
$output = shell_exec('php artisan view:clear 2>&1');
echo $output;

echo "\n=== HOÀN THÀNH SETUP ===\n";
echo "\nHướng dẫn sử dụng:\n";
echo "1. Truy cập admin panel: /admin/banners\n";
echo "2. Tạo banner mới với loại 'Banner chính' hoặc 'Banner phụ'\n";
echo "3. Banner chính sẽ hiển thị ở đầu trang (carousel)\n";
echo "4. Banner phụ sẽ hiển thị ở cuối trang (2 banner cạnh nhau)\n";
echo "5. Truy cập trang chủ: /clients để xem kết quả\n"; 