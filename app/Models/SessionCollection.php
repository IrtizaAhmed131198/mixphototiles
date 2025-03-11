<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionCollection extends Model
{
    protected $table = "session_collection";

    protected $fillable = ['product_id', 'session_id', 'image_name', 'configuration'];
}
