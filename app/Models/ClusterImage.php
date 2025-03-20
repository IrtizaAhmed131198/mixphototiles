<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClusterImage extends Model
{
    protected $table = 'cluster_images';

    protected $fillable = ['cluster_id', 'image_path'];
}
