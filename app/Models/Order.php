<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'user_email',
        'user_phone',
        'user_address',
        'user_note',
        'status_order',
        'status_payment',
        'type_payment',
        'total_price',
        'cancel_reason',
        'cancelled_by_admin_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
