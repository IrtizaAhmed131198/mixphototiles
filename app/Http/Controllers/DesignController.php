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
        $sizes        = Sizes::where('status', 1)->get();
        $indianSizes   = Sizes::where('status', 1)->where('frame_type', 'indian')->get();
        $europeanSizes = Sizes::where('status', 1)->where('frame_type', 'european')->get();
        $finish       = Finish::where('status', 1)->get();
        $led          = Led::where('status', 1)->get();

        $imageName = $request->query('image_name');
        $sessionId = $request->session()->getId();

        $images = SessionImage::where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get();

        // Determine default frame type
        $defaultFrameType = 'indian';
        if ($images->isNotEmpty() && !empty($images->first()->frame_configuration)) {
            $firstConfig = json_decode($images->first()->frame_configuration, true);
            if (!empty($firstConfig['frame_type']['type'])) {
                $defaultFrameType = $firstConfig['frame_type']['type'];
            }
        }

        // Get default size based on frame type
        if ($defaultFrameType === 'european') {
            $defaultSize = $europeanSizes->first() ?? $sizes->first();
        } else {
            $defaultSize = $indianSizes->first() ?? $sizes->first();
        }
        $defaultSizePrice = $defaultSize ? floatval($defaultSize->price) : floatval(get_setting('average_cost') ?? 0);

        $quantity = $images->count();
        if ($quantity == 0) {
            $quantity = 1;
        }

        if ($quantity === 1) {
            // Single frame — show size price directly, no formula
            $item_price = $defaultSizePrice;
        } else {
            // Multiple frames — run bundle formula with size price as base
            $subtotal     = $defaultSizePrice * $quantity;
            $bundleResult = calculateBundlePrice($subtotal, $quantity, $defaultFrameType);
            $item_price   = $bundleResult['perFrame'];
        }

        $item_price = round($item_price, 2);
        $shipping   = get_setting('shipping_price') ?? 0;

        return view('livewire.design-page', [
            'imageName'         => $imageName,
            'images'            => $images,
            'custom_color'      => $custom_color,
            'sizes'             => $sizes,
            'indianSizes'       => $indianSizes,
            'europeanSizes'     => $europeanSizes,
            'defaultFrameType'  => $defaultFrameType,
            'finish'            => $finish,
            'led'               => $led,
            'item_price'        => $item_price,
            'shipping'          => $shipping,
        ]);
    }
}
