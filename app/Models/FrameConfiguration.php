<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrameConfiguration extends Model
{
    protected $table = "frame_configurations";

    protected $fillable = [
        'image_url',
        'config',
        'session_id'
    ];
}
