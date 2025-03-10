<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionImages extends Model
{
    protected $table = "collection_images";

    protected $fillable = ['collection_id', 'image'];
}
