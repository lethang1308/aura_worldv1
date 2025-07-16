<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productsImage extends Model
{
    // tên bảng
    protected $table = "products_images";
    // tên khóa
    protected $primaryKey = "id";
    // các trường gán
    protected $fillable = ['product_id', 'path', 'is_featured', 'created_at', 'updated_at'];

    // quan hệ
    public function product(){
        return $this->belongsTo(product::class);
    }
}