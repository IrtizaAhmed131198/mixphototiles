<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'email',
        'pin_code',
        'address_line1',
        'address_line2',
        'state',
        'city',
        'alt_phone',
        'default_address',
    ];

    protected $casts = [
        'default_address' => 'boolean',
    ];
}
