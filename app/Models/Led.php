<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Led extends Model
{
    protected $table = 'led';
    protected $fillable = [
        'name',
        'image',
        'price',
        'status',
    ];
}
