<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\SessionCollection;
use App\Models\CollectionImages;

class CollectionDetail extends Component
{
    public $slug;
    public $product;
    public $imageName;
    public $collectionImages;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->with('additionalImages')->first();

        if (!$this->product) {
            abort(404); // Show 404 page if product not found
        }

        $this->imageName = request()->query('image_name');
        $data = SessionCollection::where('image_name', 'uploads/cart_images/'.$this->imageName)
            ->where('product_id', $this->product->id)
            ->first();
        if($data){
            $this->collectionImages = CollectionImages::where('collection_id', $data->id)->get();
        }

    }

    public function render()
    {
        return view('livewire.collection-detail', [
            'product' => $this->product,
            'collectionImages' => $this->collectionImages,
            'image_name' => $this->imageName
        ]);
    }
}
