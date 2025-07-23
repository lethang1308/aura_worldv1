<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'category_id', 'base_price', 'brand_id', 'status'];

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }

    public function featuredImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_featured', 1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
}
