<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;  // Make sure to import Product model

class Collections extends Component
{
    public $products = [];

    public function mount()
    {
        $this->products = Product::where('type', 'collections')
            ->where('status', 1)
            ->where('coordinates', '!=', null)
            ->get();
    }

    public function render()
    {
        return view('livewire.collections');
    }
}
