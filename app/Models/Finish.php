<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $table = 'finish';

    protected $fillable = [
        'label',
        'price',
        'status',
    ];
}
