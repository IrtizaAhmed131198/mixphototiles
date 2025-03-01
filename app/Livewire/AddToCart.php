<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;
use Illuminate\Support\Str;

class AddToCart extends Component
{
    // Listen for the 'addToCart' event from JavaScript
    protected $listeners = ['addToCart'];

    /**
     * Receives data from the frontend, processes the image,
     * and saves the frame configuration into the database.
     *
     * @param array $data
     *    $data['config']  => frame configuration (array)
     *    $data['image']   => image data (a base64 string or object URL)
     */
    public function addToCart($data)
    {
        // Retrieve configuration and image data
        $config = $data['config'] ?? [];
        $imageData = $data['image'] ?? '';

        $imagePath = null;
        // If the image is a base64 string, convert and save it to storage
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $dataString = substr($imageData, strpos($imageData, ',') + 1);
            $dataString = base64_decode($dataString);
            $extension = strtolower($type[1]); // e.g., jpg, png
            $fileName = Str::random(10) . '.' . $extension;
            $imagePath = 'uploads/' . $fileName;
            // Save image to the 'public' disk (ensure you have run: php artisan storage:link)
            Storage::disk('public')->put($imagePath, $dataString);
        }
        // If not base64, you might handle it differently (e.g., if it's an object URL, you'll need to adjust your logic)

        // Create a new CartItem using the configuration data.
        $cartItem = new CartItem();
        $cartItem->design = $config['design']['designClass'] ?? null;
        $cartItem->display_text = $config['design']['displayText'] ?? null;
        $cartItem->color_name = $config['color']['color_name'] ?? null;
        $cartItem->img_src = $config['color']['img_src'] ?? null;
        $cartItem->shadow_class = $config['color']['shadowClass'] ?? null;
        $cartItem->width = $config['size']['width'] ?? null;
        $cartItem->height = $config['size']['height'] ?? null;
        $cartItem->max_width = $config['size']['max_width'] ?? null;
        $cartItem->frame_price = $config['size']['frame_price'] ?? 0;
        $cartItem->frame_size_text = $config['size']['frameSizeText'] ?? null;
        $cartItem->finish_price = $config['finish']['finish_price'] ?? 0;
        $cartItem->frame_finish_text = $config['finish']['frameFinishText'] ?? null;
        $cartItem->led_price = $config['led']['price'] ?? 0;
        $cartItem->led_value = $config['led']['value'] ?? null;
        $cartItem->framehang_text = $config['led']['framehangText'] ?? null;
        $cartItem->image_path = $imagePath; // Save the path where the image was stored

        $cartItem->save();

        // Optionally, you can emit an event back to the frontend to update your UI.
        $this->emit('cartUpdated', $cartItem);
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
