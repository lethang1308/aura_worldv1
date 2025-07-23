<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'code', 'type', 'value', 'min_order_value', 'max_discount', 'start_date', 'end_date', 'usage_limit', 'used', 'status', 'description'
    ];
}
