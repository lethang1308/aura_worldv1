<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'status',
        'transaction_id',
        'payment_date',
    ];

    public function transaction()
    {
        return $this->hasOne(PaymentTransaction::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
