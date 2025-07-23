<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'SALE10',
            'type' => 'percent',
            'value' => 10,
            'min_order_value' => 100000,
            'max_discount' => 50000,
            'start_date' => Carbon::now()->subDays(1),
            'end_date' => Carbon::now()->addDays(10),
            'usage_limit' => 100,
            'used' => 0,
            'status' => 'active',
            'description' => 'Giảm 10% tối đa 50k cho đơn từ 100k',
        ]);
        Coupon::create([
            'code' => 'FREESHIP',
            'type' => 'fixed',
            'value' => 20000,
            'min_order_value' => 50000,
            'max_discount' => null,
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'usage_limit' => 50,
            'used' => 10,
            'status' => 'active',
            'description' => 'Giảm 20k phí ship cho đơn từ 50k',
        ]);
        Coupon::create([
            'code' => 'WELCOME50',
            'type' => 'fixed',
            'value' => 50000,
            'min_order_value' => 200000,
            'max_discount' => null,
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(20),
            'usage_limit' => 10,
            'used' => 2,
            'status' => 'inactive',
            'description' => 'Tặng 50k cho khách mới',
        ]);
    }
}
