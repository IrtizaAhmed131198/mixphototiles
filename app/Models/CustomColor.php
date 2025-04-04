<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomColor extends Model
{
    protected $table = "custom_color";

    protected $fillable = ['name', 'before_color_code', 'after_color_code', 'price', 'option_img', 'frame_img', 'status'];
}
