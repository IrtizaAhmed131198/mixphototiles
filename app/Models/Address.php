<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "addresses";

    protected $fillable = [
        'order_id',
        'user_id',
        'full_name',
        'phone_number',
        'email',
        'pincode',
        'address_line1',
        'address_line2',
        'city',
        'alternate_phone_number',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
