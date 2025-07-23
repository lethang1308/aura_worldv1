<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    /** @use HasFactory<\Database\Factories\VariantFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'variants';
    protected $fillable = [
        'product_id',
        'price',
        'stock_quantity',
        'status',
        'created_at',
        'updated_at',
    ];
    // tên khóa chính
    protected $primaryKey = 'id';
    // định nghĩa quan hệ với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attributesValue()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attributes', 'variant_id', 'attribute_value_id');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attributes', 'variant_id', 'attribute_value_id');
    }

    /**
     * Mối quan hệ với model Variant
     * CartItem thuộc về một Variant
     */
    public function cartItem()
    {
        return $this->hasOne(Variant::class);
    }
    public function OrderDetail()
    {
        return $this->hasOne(OrderDetail::class, 'variant_id', 'id');
    }
}
