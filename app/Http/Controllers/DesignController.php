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

        $quantity = session()->get('image_quantity', 0);
        if($quantity == 0){
            $quantity = 1;
        }

        $item_price = calculateFrameCost($quantity);
        if($quantity != 1){
            $item_price = $item_price / $quantity;
            $item_price = (float)$item_price;
        }
        if(!isset($item_price) && empty($item_price)){
            $item_price = floatval(get_setting('average_cost') ?? 0);
        }

        return view('livewire.design-page', [
            'imageName' => $imageName,
            'images' => $images,
            'custom_color' => $custom_color,
            'sizes' => $sizes,
            'finish' => $finish,
            'led' => $led,
            'item_price' => $item_price
        ]);
    }
}
