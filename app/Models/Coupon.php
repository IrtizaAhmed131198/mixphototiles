<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';
    protected $fillable = [
        'code',
        'discount_amount',
        'date_range',
        'title',
        'description',
        'status'
    ];
}
