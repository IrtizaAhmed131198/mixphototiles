<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product; // Make sure to import the model

class CollectionDetail extends Component
{
    public $slug;
    public $product;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->with('additionalImages')->first();

        if (!$this->product) {
            abort(404); // Show 404 page if product not found
        }
    }

    public function render()
    {
        return view('livewire.collection-detail', ['product' => $this->product]);
    }
}
