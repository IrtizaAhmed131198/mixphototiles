<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    public function checkoutEvents()
    {
        return $this->hasMany(CheckoutEvent::class)->orderBy('id');
    }

    public function latestCheckoutEvent()
    {
        return $this->hasOne(CheckoutEvent::class)->latestOfMany();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class)->with('product');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
