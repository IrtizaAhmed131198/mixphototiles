<?php
namespace App\Livewire;

use Livewire\Component;

class DesignPage extends Component
{
    public $imageName;

    public function mount()
    {
        $this->imageName = request()->query('image_name');
    }

    public function render()
    {
        return view('livewire.design-page', [
            'imageName' => $this->imageName,
        ]);
    }
}
