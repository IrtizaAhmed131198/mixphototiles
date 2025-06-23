<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionImage;
use App\Models\CustomColor;
use App\Models\Sizes;
use App\Models\Finish;
use App\Models\Led;

class DesignController extends Controller
{
    public function show(Request $request)
    {
        $custom_color = CustomColor::where('status', 1)->get();
        $sizes = Sizes::where('status', 1)->get();
        $finish = Finish::where('status', 1)->get();
        $led = Led::where('status', 1)->get();

        $imageName = $request->query('image_name');
        $sessionId = $request->session()->getId();

        $images = SessionImage::where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('livewire.design-page', [
            'imageName' => $imageName,
            'images' => $images,
            'custom_color' => $custom_color,
            'sizes' => $sizes,
            'finish' => $finish,
            'led' => $led,
        ]);
    }
}
