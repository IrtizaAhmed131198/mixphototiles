<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomColor extends Model
{
    protected $table = "custom_color";

    protected $fillable = ['name', 'col', 'price', 'option_img', 'frame_img', 'status'];
}
