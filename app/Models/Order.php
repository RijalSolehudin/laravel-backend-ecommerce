<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'seller_id',
        'total_price',
        'shipping_price',
        'grand_total',
        'status',
        'payment_va_name',
        'payment_va_number',
        'shipping_service',
        'shipping_number',
        'transaction_number'
    ];

    public function product() {
        return $this->belongsTo('products');
    }
    public function address() {
        return $this->belongsTo('addresses');
    }
    public function seller() {
        return $this->belongsTo('users');
    }
}
