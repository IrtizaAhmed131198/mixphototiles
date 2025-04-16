<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\SessionImage;
use App\Models\CustomColor;
use App\Models\Sizes;
use App\Models\Finish;
use App\Models\Led;

class DesignPage extends Component
{
    public $imageName;
    public $images;
    public $custom_color;
    public $sizes;
    public $finish;
    public $led;

    public function mount()
    {
        $this->custom_color = CustomColor::where('status', 1)->get();

        $this->sizes = Sizes::where('status', 1)->get();

        $this->finish = Finish::where('status', 1)->get();

        $this->led = Led::where('status', 1)->get();

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
            'sizes' => $this->sizes,
            'finish' => $this->finish,
            'led' => $this->led
        ]);
    }
}
