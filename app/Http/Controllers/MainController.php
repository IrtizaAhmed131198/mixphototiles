<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrameConfiguration;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function update_config(Request $request)
    {
        $imageData = $request->input('image');  // This is now a Base64 data URL (optional).
        $configJson = $request->input('config');
        $sessionId = session()->getId();

        $imagePath = null;

        if ($imageData) {
            // Check if the image data is a Base64 data URL.
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $dataString = substr($imageData, strpos($imageData, ',') + 1);
                $dataString = base64_decode($dataString);
                // Determine file extension (default to jpg if not found)
                $extension = strtolower($type[1]) ?: 'jpg';
                // Generate a unique file name
                $fileName = time().'_'.\Illuminate\Support\Str::random(10).'.'.$extension;
                $imagePath = 'uploads/' . $fileName;

                // Ensure the uploads directory exists in the public folder
                $uploadDir = public_path('uploads');
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Save the file to the public/uploads folder
                file_put_contents(public_path($imagePath), $dataString);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid image data provided.'
                ], 400);
            }
        }

        // Find existing record (optional step - you need to decide what you match on)
        $frameConfig = FrameConfiguration::where('session_id', $sessionId)->first();

        if ($frameConfig) {
            // Update existing record
            $frameConfig->config = $configJson;

            // Only update image_url if new image data was provided
            if ($imagePath) {
                $frameConfig->image_url = $imagePath;
            }

            $frameConfig->save();
        } else {
            // Create new record if no existing one found
            $frameConfig = FrameConfiguration::create([
                'config' => $configJson,
                'image_url' => $imagePath,
                'session_id' => $sessionId
            ]);
        }

        return response()->json(['success' => true, 'data' => $frameConfig]);
    }

    public function get_images()
    {
        $images = FrameConfiguration::where('session_id', session()->getId())
            ->get(['image_url as url']);
        return response()->json(['success' => true, 'images' => $images]);
    }

    public function destroy(Request $request)
    {
        $imageUrl = $request->input('image'); // This is the URL from the frontend (e.g. blob-converted URL or the file path)

        // Find the record by matching the image file path stored in the database.
        $frameConfig = FrameConfiguration::where('image_url', $imageUrl)->first();
        if (!$frameConfig) {
            return response()->json(['success' => false, 'message' => 'Configuration not found.'], 404);
        }

        // Delete the file from the public/uploads folder
        $filePath = public_path($frameConfig->image_url);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record from the database
        $frameConfig->delete();

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        // Validate incoming data (adjust rules as needed)
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'price'  => 'required|numeric',
            'image'  => 'required|string', // URL of the image file
        ]);

        // Generate a slug from the product name
        $data['slug'] = Str::slug($data['name']);
        $data['type'] = 'manual';

        // Create the product record in the products table
        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    public function cart()
    {
        return view('cart');
    }

    public function order_summary()
    {
        return view('order_summary');
    }
}
