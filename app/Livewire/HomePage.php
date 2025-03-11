<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HomePage extends Component
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
        return view('livewire.home-page');
    }
}
