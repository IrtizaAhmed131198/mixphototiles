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
        $luxuryTileSizes = Sizes::where('status', 1)->where('frame_type', 'luxury_tiles')->get();
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
        if ($defaultFrameType === 'luxury_tiles') {
            $defaultSize = $luxuryTileSizes->first() ?? $europeanSizes->first() ?? $sizes->first();
        } elseif ($defaultFrameType === 'european') {
            $defaultSize = $europeanSizes->first() ?? $sizes->first();
        } else {
            $defaultSize = $indianSizes->first() ?? $sizes->first();
        }
        $pricingItems = [];
        foreach ($images as $image) {
            $config = json_decode((string) $image->frame_configuration, true) ?: [];
            $frameConfig = $config['frame_configuration'] ?? $config;
            if (is_string($frameConfig)) {
                $frameConfig = json_decode($frameConfig, true) ?: [];
            }
            $frameType = $frameConfig['frame_type']['type'] ?? ($frameConfig['frame_type'] ?? $defaultFrameType);
            $sizeLabel = $frameConfig['size']['frameSizeText'] ?? null;
            $sizePrice = (float) ($frameConfig['size']['frame_price'] ?? 0);
            $addonPrice = (float) ($frameConfig['finish']['finish_price'] ?? 0)
                + (float) ($frameConfig['led']['price'] ?? 0);
            $pricingItems[] = framePricingDetails(
                $frameType,
                $sizeLabel ?? $defaultSize?->label,
                $sizePrice > 0 ? $sizePrice : (float) ($defaultSize?->price ?? 0),
                $addonPrice,
                $addonPrice > 0
            );
        }

        if (!$pricingItems) {
            $pricingItems[] = framePricingDetails(
                $defaultFrameType,
                $defaultSize?->label,
                (float) ($defaultSize?->price ?? get_setting('average_cost', 0))
            );
        }

        $pricingSummary = calculateAutomaticQuantityPricing($pricingItems);
        $quantity = $pricingSummary['quantity'];
        $item_price = $quantity > 0
            ? round($pricingSummary['bundle_total'] / $quantity, 2)
            : 0.0;
        $shipping = quantityShippingCharge($quantity);
        $shippingSavings = $quantity >= 3 ? 80.0 : 0.0;
        $pricingCatalog = framePricingCatalog();
        $pricingCatalog['_fallback_floors'] = [
            'indian' => (float) get_setting('indian_floor_price', 0),
            'european' => (float) get_setting('floor_price', 0),
        ];

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
            'pricingSummary'    => $pricingSummary,
            'shippingSavings'   => $shippingSavings,
            'pricingCatalog'    => $pricingCatalog,
        ]);
    }
}
