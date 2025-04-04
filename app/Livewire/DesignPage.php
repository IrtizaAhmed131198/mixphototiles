<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\SessionImage;
use App\Models\CustomColor;

class DesignPage extends Component
{
    public $imageName;
    public $images;
    public $custom_color;

    public function mount()
    {
        $this->custom_color = CustomColor::where('status', 1)->get();

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
            'custom_color' => $this->custom_color,
        ]);
    }
}
