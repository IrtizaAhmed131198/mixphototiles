<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomColor extends Model
{
    protected $table = "custom_color";

    protected $fillable = ['name', 'price', 'option_img', 'frame_img', 'status'];
}
