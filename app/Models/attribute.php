<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    // tên bảng
    protected $table = 'attributes';
    // khóa chính
    protected $primarykey = 'id';
    public function attributesValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}