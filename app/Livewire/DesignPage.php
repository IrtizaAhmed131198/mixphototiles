<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\SessionImage;

class DesignPage extends Component
{
    public $imageName;
    public $images;

    public function mount()
    {
        $this->imageName = request()->query('image_name');

        $sessionId = session()->getId();

        $this->images = SessionImage::where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

    public function render()
    {
        return view('livewire.design-page', [
            'imageName' => $this->imageName,
            'images' => $this->images,
        ]);
    }
}
