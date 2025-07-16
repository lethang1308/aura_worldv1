<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    protected $table = 'roles'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['role_name', 'description']; // Các trường có thể được gán giá trị hàng loạt
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id'); // Quan hệ với mô hình User
    }
}