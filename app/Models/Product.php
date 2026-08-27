<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = ['name', 'slug', 'description', 'price', 'frame_note', 'discount', 'stock', 'image', 'no_coordinates_image', 'coordinates_image', 'coordinates', 'frame_config', 'status', 'type'];

    public function additionalImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
