<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = ['name', 'slug', 'description', 'price', 'discount', 'stock', 'image', 'status', 'type'];
}
