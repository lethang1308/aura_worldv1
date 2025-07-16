<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentTransactionFactory> */
    use HasFactory;
    protected $table = 'payment_transactions';
    protected $fillable = [
        'payment_id',
        'order_id',
        'gateway',
        'transaction_status',
        'amount',
        'currency',
        'transaction_date',
        'response_transaction',
    ];
}