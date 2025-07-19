<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variants;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category_id', 'base_price'];

    protected $table = 'products';
    protected $primaryKey = 'id';
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
        return $this->hasMany(Variants::class, 'product_id');
    }

    public function featuredImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_featured', 1);
    }
}
