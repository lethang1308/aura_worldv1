<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
    // tên bảng
    protected $table = 'attributes';
    // khóa chính
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public function attributeValues()
    {
        return $this->belongsToManys(AttributeValue::class);
    }
}