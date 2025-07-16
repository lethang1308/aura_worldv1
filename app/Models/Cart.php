<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'total_quantity',
        'total_price',
    ];
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}