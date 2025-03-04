<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrameConfiguration;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\SessionImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // public function update_config(Request $request)
    // {
    //     $imageData = $request->input('image');  // This is now a Base64 data URL (optional).
    //     $configJson = $request->input('config');
    //     $sessionId = session()->getId();

    //     $imagePath = null;

    //     if ($imageData) {
    //         // Check if the image data is a Base64 data URL.
    //         if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
    //             $dataString = substr($imageData, strpos($imageData, ',') + 1);
    //             $dataString = base64_decode($dataString);
    //             // Determine file extension (default to jpg if not found)
    //             $extension = strtolower($type[1]) ?: 'jpg';
    //             // Generate a unique file name
    //             $fileName = time().'_'.\Illuminate\Support\Str::random(10).'.'.$extension;
    //             $imagePath = 'uploads/' . $fileName;

    //             // Ensure the uploads directory exists in the public folder
    //             $uploadDir = public_path('uploads');
    //             if (!is_dir($uploadDir)) {
    //                 mkdir($uploadDir, 0777, true);
    //             }

    //             // Save the file to the public/uploads folder
    //             file_put_contents(public_path($imagePath), $dataString);
    //         } else {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid image data provided.'
    //             ], 400);
    //         }
    //     }

    //     // Find existing record (optional step - you need to decide what you match on)
    //     $frameConfig = FrameConfiguration::where('session_id', $sessionId)->first();

    //     if ($frameConfig) {
    //         // Update existing record
    //         $frameConfig->config = $configJson;

    //         // Only update image_url if new image data was provided
    //         if ($imagePath) {
    //             $frameConfig->image_url = $imagePath;
    //         }

    //         $frameConfig->save();
    //     } else {
    //         // Create new record if no existing one found
    //         $frameConfig = FrameConfiguration::create([
    //             'config' => $configJson,
    //             'image_url' => $imagePath,
    //             'session_id' => $sessionId
    //         ]);
    //     }

    //     return response()->json(['success' => true, 'data' => $frameConfig]);
    // }

    public function update_config(Request $request)
    {
        $imageName = $request->input('image_name');
        $newConfigPart = $request->input('frame_config'); // This will be the data to update (e.g., "design", "color", etc.)
        $type = $request->input('type'); // This will be 'design', 'color', 'finish', etc.

        // Find the session image record
        $sessionImage = SessionImage::where('filename', $imageName)->first();

        if (!$sessionImage) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ]);
        }

        // Decode the existing frame_configuration JSON into an array
        $frameConfig = json_decode($sessionImage->frame_configuration, true);

        // Update the specified type (key) only
        $frameConfig[$type] = $newConfigPart;

        // Save the updated frame_configuration back to the database
        $sessionImage->frame_configuration = json_encode($frameConfig, JSON_UNESCAPED_SLASHES);
        $sessionImage->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst($type) . ' updated successfully'
        ]);
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

    public function upload_image(Request $request)
    {
        $sessionId = session()->getId();  // Get current session ID

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Generate a timestamped filename
            $newFileName = time() . '_' . $file->getClientOriginalName();

            // Save to public/uploads (make sure /public/uploads directory exists and is writable)
            $file->move(public_path('uploads'), $newFileName);

            // Save only the relative path to the database (without the full URL)
            $filePath = 'uploads/' . $newFileName;

            $frameConfiguration = $request->input('frame_configuration');

            // Save to database
            $session_images = new SessionImage();
            $session_images->session_id = $sessionId;
            $session_images->filename = $newFileName;
            $session_images->file_url = $filePath;
            $session_images->frame_configuration = $frameConfiguration;
            $session_images->save();

            return response()->json([
                'success' => true,
                'file_url' => $filePath,
                'filename' => $newFileName,
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function get_session_images()
    {
        $sessionId = session()->getId();

        $images = SessionImage::where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get();

        return response()->json($images);
    }

    public function delete_session_image(Request $request)
    {
        $sessionId = session()->getId();
        $imageName = $request->input('image_name');


        $deleted = SessionImage::where('session_id', $sessionId)
            ->where('filename', $imageName)
            ->delete();

        if ($deleted) {
            $filePath = public_path($imageName);
            if (file_exists($filePath)) {
                unlink($filePath);  // delete file from public folder
            }

            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to delete image']);
    }

    public function get_frame_config(Request $request)
    {
        $filename = $request->input('filename');
        $sessionImage = SessionImage::where('filename', $filename)->first();

        if (!$sessionImage) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'frame_configuration' => $sessionImage
        ]);
    }

}
