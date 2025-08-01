<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Bộ sưu tập mùa hè 2024',
                'description' => 'Khám phá những hương thơm mới nhất cho mùa hè',
                'image' => 'images/banners/banner1.jpg',
                'link' => 'https://example.com/summer-collection',
                'status' => 'active',
                'type' => 'main',
                'sort_order' => 1,
            ],
            [
                'title' => 'Giảm giá 50% cho thành viên mới',
                'description' => 'Đăng ký ngay để nhận ưu đãi đặc biệt',
                'image' => 'images/banners/banner2.jpg',
                'link' => 'https://example.com/new-member',
                'status' => 'active',
                'type' => 'main',
                'sort_order' => 2,
            ],
            [
                'title' => 'Hương thơm cao cấp',
                'description' => 'Trải nghiệm những hương thơm độc đáo và sang trọng',
                'image' => 'images/banners/banner3.jpg',
                'link' => 'https://example.com/premium-fragrances',
                'status' => 'active',
                'type' => 'main',
                'sort_order' => 3,
            ],
            [
                'title' => 'Bộ sưu tập nam',
                'description' => 'Hương thơm nam tính và mạnh mẽ',
                'image' => 'images/banners/banner4.jpg',
                'link' => 'https://example.com/mens-collection',
                'status' => 'active',
                'type' => 'secondary',
                'sort_order' => 1,
            ],
            [
                'title' => 'Bộ sưu tập nữ',
                'description' => 'Hương thơm nữ tính và quyến rũ',
                'image' => 'images/banners/banner5.jpg',
                'link' => 'https://example.com/womens-collection',
                'status' => 'active',
                'type' => 'secondary',
                'sort_order' => 2,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
} 