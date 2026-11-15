<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = ['name', 'slug', 'description', 'price', 'indian_price', 'frame_note', 'indian_frame_note', 'discount', 'stock', 'image', 'no_coordinates_image', 'coordinates_image', 'coordinates', 'frame_config', 'status', 'type', 'collection_category'];

    public function isTileCollection(): bool
    {
        return $this->collection_category === 'tiles';
    }

    public function normalizeCollectionConfiguration(array $configuration): array
    {
        if ($this->isTileCollection()) {
            $configuration['frame_type'] = [
                'type' => 'european',
                'name' => 'European Style Frames',
            ];
        }

        return $configuration;
    }

    public function additionalImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
