<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrameConfiguration;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\SessionImage;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Address;
use App\Models\CollectionImages;
use App\Models\SessionCollection;
use App\Models\User;
use App\Models\ClusterImage;
use App\Models\Coupon;
use App\Models\State;
use App\Models\City;
use App\Models\ProductImage;
use App\Models\Finish;
use App\Models\Led;
use App\Models\CustomColor;
use App\Models\Sizes;
use App\Models\ShippingAddress;
use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Mail\OrderPlacedUserMail;
use App\Mail\OrderPlacedAdminMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
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
            'message' => ucfirst($type) . ' updated successfully',
            'data' => $sessionImage
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
        $cartItems = session()->get('cart', []);
        $discount = (float) get_setting('discount') ?? 0;
        $shipping_price = get_setting('shipping_price') ?? 0;
        $gift = 30;
        $today = Carbon::today()->format('Y-m-d');
        $coupons = DB::table('coupon')
            ->where('status', 1)
            ->whereDate(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(date_range, ' - ', -1), '%Y-%m-%d')"), '>=', $today)
            ->get();

        $couponsSelect = DB::table('coupon')
            ->where('status', 1)
            ->whereDate(DB::raw("STR_TO_DATE(SUBSTRING_INDEX(date_range, ' - ', -1), '%Y-%m-%d')"), '>=', $today)
            ->pluck('discount_amount', 'code')
            ->map(function ($amount) {
                return (float) $amount;
            });
        return view('cart', compact('cartItems', 'discount', 'gift', 'coupons', 'couponsSelect', 'shipping_price'));
    }

    public function upload_image(Request $request)
    {
        $sessionId = session()->getId();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $timestamp = time();

            // Define file names
            $processedFileName = $timestamp . '.' . $extension;
            $originalFileName = $timestamp . '_original.' . $extension;

            // Ensure upload directory exists
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Move original file
            $file->move($uploadPath, $originalFileName);

            // Optionally process and save processed file
            // For now, just copy the original file as "processed"
            copy($uploadPath . '/' . $originalFileName, $uploadPath . '/' . $processedFileName);

            $frameConfiguration = $request->input('frame_configuration');

            // Save to database
            $session_images = new SessionImage();
            $session_images->session_id = $sessionId;
            $session_images->filename = $timestamp;
            $session_images->original_file_url = 'uploads/' . $originalFileName;
            $session_images->file_url = 'uploads/' . $processedFileName;
            $session_images->frame_configuration = $frameConfiguration;
            $session_images->save();

            //quantity session
            $quantity = session()->get('image_quantity', 0);
            session()->put('image_quantity', $quantity + 1);


            return response()->json([
                'success' => true,
                'file_url' => 'uploads/' . $processedFileName,
                'filename' => $processedFileName,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file found in request or file failed to upload.'
        ], 400);
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
        $imageSrc = $request->input('image_src');

        $sessionImage = SessionImage::where('session_id', $sessionId)
            ->where('filename', $imageName)
            ->first();

        if (!$sessionImage) {
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }

        $deleted = $sessionImage->delete();

        if ($deleted) {
            $quantity = session()->get('image_quantity', 0);
            session()->put('image_quantity', max(0, $quantity - 1));

            $filePath = public_path($imageSrc);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $originalFilePath = public_path($sessionImage->original_file_url);
            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
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

    public function save_cropped_image(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'cropped_image' => 'required|string',  // This will be the base64 image string
        ]);

        $filename = $request->input('filename');
        $sessionImage = SessionImage::where('filename', $filename)->first();

        if (!$sessionImage) {
            return response()->json([
                'success' => false,
                'message' => 'Image record not found for filename: ' . $filename,
            ], 404);
        }

        // Decode Base64 image
        $base64Image = $request->input('cropped_image');
        $imageData = explode(',', $base64Image)[1]; // Remove "data:image/jpeg;base64," part
        $imageData = base64_decode($imageData);

        // Generate new filename
        $newFileName = time() . '_cropped.jpg'; // or you can keep original name
        $filePath = 'uploads/' . $newFileName;

        // Save new image file
        file_put_contents(public_path($filePath), $imageData);

        // Delete old image file
        $oldFilePath = public_path($sessionImage->file_url);
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $withoutExtension = pathinfo($newFileName, PATHINFO_FILENAME);

        // Update database record
        $sessionImage->filename = $withoutExtension;
        $sessionImage->file_url = $filePath;
        $sessionImage->crop = 1;
        $sessionImage->save();

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully.',
            'file_url' => asset($filePath),
            'filename' => $withoutExtension,
        ]);
    }

    public function reset_cropped_image(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $filename = $request->input('filename');
        $sessionImage = SessionImage::where('filename', $filename)->first();

        if($sessionImage->crop == 0){
            return response()->json([
                'success' => false,
                'message' => 'Image is not cropped.'
            ], 400);
        }

        if (!$sessionImage) {
            return response()->json([
                'success' => false,
                'message' => 'Image not found.'
            ], 404);
        }

        $originalFileName = str_replace(['uploads/', '_cropped'], '', $sessionImage->file_url);

        // Paths
        $originalPath = public_path($sessionImage->original_file_url); // where the original image is stored
        $destinationPath = public_path('uploads/'. $originalFileName);       // where the restored image should go

        // Delete cropped image if it exists
        $currentPath = public_path($sessionImage->file_url);
        if (file_exists($currentPath)) {
            unlink($currentPath);
        }

        // Copy original to destination
        if (file_exists($originalPath)) {
            copy($originalPath, $destinationPath);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Original image not found in backup folder.'
            ], 404);
        }

        $withoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);

        // Update DB
        $sessionImage->filename = $withoutExtension;
        $sessionImage->file_url = 'uploads/' . $originalFileName;
        $sessionImage->crop = 0;
        $sessionImage->save();

        return response()->json([
            'success' => true,
            'message' => 'Image reset successfully.',
            'file_url' => asset('uploads/' . $originalFileName)
        ]);
    }

    public function get_grand_total()
    {
        $sessionId = session()->getId();
        $sessionImages = SessionImage::where('session_id', $sessionId)->select('frame_configuration')->get();

        // Decode frame_configuration if stored as JSON
        foreach ($sessionImages as $image) {
            $image->frame_configuration = json_decode($image->frame_configuration, true);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Frame Config.',
            'data' => $sessionImages,
        ]);
    }

    public function get_all_images()
    {
        $sessionId = session()->getId();
        $sessionImages = SessionImage::where('session_id', $sessionId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Get Frame Config.',
            'data' => $sessionImages,
        ]);
    }

    public function add_to_cart(Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $sessionId = session()->getId();
        $sessionImages = SessionImage::where('session_id', $sessionId)->get();

        if ($sessionImages->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No images found in your session to add to cart.',
            ]);
        }

        $userId = auth()->id();  // Assuming user is logged in
        $sessionCart = session()->get('cart', []);
        
        // Remove existing manual items from the cart to replace them with the updated session images
        foreach ($sessionCart as $key => $item) {
            if (isset($item['type']) && $item['type'] === 'manual') {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->delete();
                }
                unset($sessionCart[$key]);
            }
        }
        $sessionCart = array_values($sessionCart);

        $productsAdded = [];

        $subtotal = 0;

        foreach ($sessionImages as $sessionImage) {
            $frameConfig = json_decode($sessionImage->frame_configuration, true);

            $sizePrice   = (float) ($frameConfig['size']['frame_price'] ?? 0);
            $finishPrice = (float) ($frameConfig['finish']['finish_price'] ?? 0);
            $ledPrice    = (float) ($frameConfig['led']['price'] ?? 0);

            $unitPrice = $sizePrice > 0
                ? $sizePrice + $finishPrice + $ledPrice
                : (float) get_setting('average_cost') + $finishPrice + $ledPrice;

            $subtotal += $unitPrice;
        }

        foreach ($sessionImages as $sessionImage) {
            // Build product name using frame configuration details (assume frame_configuration has JSON data)
            $frameConfig = json_decode($sessionImage->frame_configuration, true);

            $name = $frameConfig['design']['displayText'] . " Frame (" .
                    $frameConfig['color']['color_name'] . ", " .
                    $frameConfig['size']['frameSizeText'] . ", " .
                    $frameConfig['finish']['frameFinishText'];
            if (strtolower($frameConfig['led']['value']) === 'yes') {
                $name .= ', LED Frame';
            }
            $name .= ')';

            // Slug (make unique slug from name)
            $slug = Str::slug($name . '-' . time(). '-'.$sessionImage['id']);

            //price
            // $price =
            //     (float) ($frameConfig['led']['price'] ?? 0) +
            //     (float) ($frameConfig['size']['frame_price'] ?? 0) +
            //     (float) ($frameConfig['color']['color_price'] ?? 0) +
            //     (float) ($frameConfig['design']['design_price'] ?? 0) +
            //     (float) ($frameConfig['finish']['finish_price'] ?? 0);

            //     // dd($frameConfig);
            // if ($price == 0) {
            //     $sellingPrice = calculateFrameCost($quantity);
            //     $price = $sellingPrice / $quantity;
            //     $price = round($price, 2);
            // }
            // dd($price);

            // Apply new bundle pricing formula
            $bundleResult = calculateBundlePrice($subtotal, $quantity);

            // Per frame price after bundle discount
            $price = round($bundleResult['perFrame'], 2);

            // Create product in `products` table
            $product = Product::create([
                'name' => $name,
                'slug' => $slug,
                'description' => 'Custom frame product', // You can adjust
                'price' => $price, // Assuming price is in frame_configuration
                'discount' => 0,
                'stock' => 1,
                'image' => $sessionImage->file_url,
                'frame_config' => $sessionImage->frame_configuration ?? '',
                'status' => 1,
                'type' => 'manual',
            ]);

            $product_images = new ProductImage();
            $product_images->product_id = $product->id;
            $product_images->image_path = $sessionImage->file_url;
            $product_images->crop_image_path = $sessionImage->original_file_url;
            $product_images->save();

            // Add product to `carts` table
            $sessionCart[] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $product->image,
                'image_name' => $sessionImage->filename,
                'quantity'   => 1,
                'price'      => $price,
                'total'      => $bundleResult['bundleTotal'] + (float)(get_setting('delivery_cost') ?? 0), // grand total with delivery
                'type'       => 'manual',
                'slug'       => ''
            ];

            $productsAdded[] = $product;
        }

        // Save updated cart to session
        session()->put('cart', $sessionCart);

        return response()->json([
            'success' => true,
            'message' => count($productsAdded) . ' frame(s) added to cart.',
            'products' => $productsAdded,
        ]);
    }

    public function add_to_cart_collection(Request $request)
    {
        // dd($request->all());
        $image_name = asset('uploads/cart_images/'.$request->input('exist_image'));
        $getCart = session()->get('cart'); // Get the current cart session

        if ($getCart != null) {
            $existingImageIndex = null;
            foreach ($getCart as $index => $item) {
                if ($item['image'] == $image_name) {
                    $existingImageIndex = $index;
                    break;
                }
            }

            if ($existingImageIndex !== null) {
                // If image with the same name exists, remove it from the cart
                unset($getCart[$existingImageIndex]);

                // Re-index the array to ensure no gaps in indices
                $getCart = array_values($getCart);

                // Update the session with the modified cart
                session()->put('cart', $getCart);
            }
        }

        // Retrieve the updated cart session and dump it
        $sessionCart = session()->get('cart', []);


        // Define upload path in public folder
        $uploadPath = public_path('uploads/cart_images/');

        // Ensure directory exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Save the uploaded image
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $mainImageName = uniqid('cart_') . '.' . $mainImage->getClientOriginalExtension();

            // Move image to public/uploads/cart_images
            $mainImage->move($uploadPath, $mainImageName);

            // Public accessible URL
            $imageUrl = asset('uploads/cart_images/' . $mainImageName);
        }

        // Slug (make unique slug from name)
        $slug = Str::slug($request->input('name') . '-' . time(). '-'.$request->input('product_id'));

        $exist_prod = Product::find($request->input('product_id'));

        if($request->input('temp_id') != null){
            $product = Product::find($request->input('temp_id'));
            $product->update([
                'price' => $request->input('price'),
                'image' => $exist_prod->image,
                'no_coordinates_image' => $exist_prod->no_coordinates_image,
                'coordinates_image' => $exist_prod->coordinates_image,
                'coordinates' => $exist_prod->coordinates,
                'frame_config' => $request->input('configuration') ?? '',
            ]);
        }else{
            $product = Product::create([
                'name' => $request->input('name'),
                'slug' => $slug,
                'description' => 'Custom frame product', // You can adjust
                'price' => $request->input('price'), // Assuming price is in frame_configuration
                'discount' => 0,
                'stock' => 1,
                'image' => $exist_prod->image,
                'no_coordinates_image' => $exist_prod->no_coordinates_image,
                'coordinates_image' => $exist_prod->coordinates_image,
                'coordinates' => $exist_prod->coordinates,
                'frame_config' => $request->input('configuration') ?? '',
                'status' => 1,
                'type' => 'manual_collection',
            ]);
        }


        // Add product to session cart
        $sessionCart[] = [
            'product_id' => $product->id,
            'name' => $request->input('name'),
            'image' => $imageUrl, // Image stored in public folder
            'quantity' => 1,
            'price' => $request->input('price'),
            'total' => $request->input('price'),
            'type' => 'collection',
            'slug' => $request->input('slug'),
        ];

        session()->put('cart', $sessionCart);

        $sessionCollection = new SessionCollection();
        $sessionCollection->product_id = $product->id;
        $sessionCollection->session_id = session()->getId();
        $sessionCollection->image_name = 'uploads/cart_images/' . $mainImageName;
        $sessionCollection->configuration = $request->input('configuration');
        $sessionCollection->price = $request->input('price');
        $sessionCollection->save();

        if ($sessionCollection->id) {
            $tempArr = json_decode($request->input('colImageArr'));
            $tempOrgArr = json_decode($request->input('colImageOrignalArr'));
            $count = 1;

            // Process both arrays together
            foreach ($tempArr as $key => $imageUrl) {
                $originalImageUrl = $tempOrgArr[$key] ?? null;

                // Process main image
                $imageName = $this->processAndSaveImage($imageUrl, $request->input('name'), $count);

                // Process original image if it exists
                $originalImageName = $originalImageUrl ?
                    $this->processAndSaveImage($originalImageUrl, $request->input('name') . '_original', $count) :
                    $imageName;

                // Save the image paths in CollectionImages table
                $collectionImage = new CollectionImages();
                $collectionImage->collection_id = $sessionCollection->id;
                $collectionImage->image = 'uploads/collections/' . $imageName;
                $collectionImage->original_image = 'uploads/collections/' . $originalImageName;
                $collectionImage->save();

                // Save in ProductImage table
                $product_images = new ProductImage();
                $product_images->product_id = $product->id;
                $product_images->image_path = 'uploads/collections/' . $imageName;
                $product_images->crop_image_path = 'uploads/collections/' . $originalImageName;
                $product_images->save();

                $count++;
            }
        }

        return response()->json(['success' => true, 'message' => 'Added to cart successfully!', 'image' => $imageUrl]);
    }

    private function processAndSaveImage($imageUrl, $namePrefix, $count)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $imageUrl, $type)) {
            // Handle base64 image
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $imageUrl));
            $extension = $type[1] ?? 'png';

            $imageName = $namePrefix . '_' . time() . '_' . $count . '.' . $extension;
            $imagePath = public_path('uploads/collections/' . $imageName);
            file_put_contents($imagePath, $imageData);

            return $imageName;
        } elseif (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            // Handle image from URL
            $imageData = file_get_contents($imageUrl);

            if ($imageData !== false) {
                $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $extension = 'png';
                }

                $imageName = $namePrefix . '_' . time() . '_' . $count . '.' . $extension;
                $imagePath = public_path('uploads/collections/' . $imageName);
                file_put_contents($imagePath, $imageData);

                return $imageName;
            }
        }

        // Return a default name if processing fails
        return $namePrefix . '_' . time() . '_' . $count . '.png';
    }

    public function save_coupon(Request $request)
    {
        $coupon = $request->input('coupon');
        $discount = $request->input('discount');

        Session::put('applied_coupon', [
            'code' => $coupon,
            'discount' => $discount
        ]);

        return response()->json([
            'message' => 'Coupon saved successfully',
            'coupon' => Session::get('applied_coupon')
        ]);
    }

    public function remove_coupon()
    {
        Session::forget('applied_coupon');

        return response()->json([
            'message' => 'Coupon removed successfully'
        ]);
    }

    public function get_applied_coupon()
    {
        $coupon = Session::get('applied_coupon');

        if ($coupon) {
            return response()->json([
                'coupon' => $coupon
            ]);
        } else {
            return response()->json([
                'coupon' => null
            ]);
        }
    }

    public function remove_from_cart(Request $request)
    {
        $productId = $request->input('product_id');
        $imageName = $request->input('image_name'); // Receive image name from AJAX

        $sessionCart = session()->get('cart', []);

        // Step 1: find the removed item(s)
        $removedItems = array_filter($sessionCart, function ($item) use ($productId) {
            return $item['product_id'] == $productId;
        });
        // dd($sessionCart);

        // Step 2: delete removed product(s) from DB
        foreach ($removedItems as $removed) {
            $product = Product::find($removed['product_id']);
            if ($product) {
                $product->delete(); // permanently delete
                // OR $product->update(['status' => 0]); // soft remove if you prefer
            }

            if (!empty($removed['image_name'])) {

                $sessionId = session()->getId();

                $sessionImage = SessionImage::where('session_id', $sessionId)
                    ->where('filename', $removed['image_name'])
                    ->first();

                if ($sessionImage) {

                    // delete DB record
                    $sessionImage->delete();

                    // delete files
                    $filePath = public_path($sessionImage->filename);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $originalFilePath = public_path($sessionImage->original_file_url);
                    if (file_exists($originalFilePath)) {
                        unlink($originalFilePath);
                    }

                    // update quantity
                    $quantity = session()->get('image_quantity', 0);
                    session()->put('image_quantity', max(0, $quantity - 1));
                }
            }
        }

        // Step 3: keep only the remaining items in cart
        $updatedCart = array_filter($sessionCart, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        // Step 4: recalc subtotal first (only for manual items)
        $subtotal = 0;
        $manualItemsCount = 0;

        foreach ($updatedCart as $item) {
            if (isset($item['type']) && $item['type'] == 'collection') {
                continue;
            }

            $product = Product::find($item['product_id']);
            if ($product) {
                if ($product->type == 'collection' || $product->type == 'manual_collection') {
                    continue;
                }

                $frameConfig = json_decode($product->frame_config, true);

                $sizePrice   = (float) ($frameConfig['size']['frame_price'] ?? 0);
                $finishPrice = (float) ($frameConfig['finish']['finish_price'] ?? 0);
                $ledPrice    = (float) ($frameConfig['led']['price'] ?? 0);

                $unitPrice = $sizePrice > 0
                    ? $sizePrice + $finishPrice + $ledPrice
                    : (float) get_setting('average_cost') + $finishPrice + $ledPrice;

                $subtotal += $unitPrice;
                $manualItemsCount++;
            }
        }

        // Apply SAME bundle logic (only if there are remaining manual items)
        if ($manualItemsCount > 0) {
            $bundleResult = calculateBundlePrice($subtotal, $manualItemsCount);

            // Step 5: update per item price (only for manual items)
            foreach ($updatedCart as &$item) {
                if (isset($item['type']) && $item['type'] == 'collection') {
                    continue;
                }

                $product = Product::find($item['product_id']);
                if ($product) {
                    if ($product->type == 'collection' || $product->type == 'manual_collection') {
                        continue;
                    }

                    $price = round($bundleResult['perFrame'], 2);

                    $item['price'] = $price;
                    $item['total'] = $bundleResult['bundleTotal'] + (float)(get_setting('delivery_cost') ?? 0);

                    $product->price = $price;
                    $product->save();
                }
            }
        }

        // Save updated cart back to session
        session()->put('cart', array_values($updatedCart));

        // dd($updatedCart, $removedItems);

        // 2. Delete image from SessionImage table and public folder
        // $deleted = SessionImage::where('filename', $imageName)->delete();

        // if ($deleted) {
        //     $filePath = public_path($imageName);
        //     if (file_exists($filePath)) {
        //         unlink($filePath);  // Delete the image file
        //     }
        // }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully.'
        ]);
    }

    public function clear_cart()
    {
        $cart = session()->get('cart', []);
        $sessionId = session()->getId();

        foreach ($cart as $item) {

            if (!empty($item['image_name'])) {

                $sessionImage = SessionImage::where('session_id', $sessionId)
                    ->where('filename', $item['image_name'])
                    ->first();

                if ($sessionImage) {

                    $sessionImage->delete();

                    $filePath = public_path($sessionImage->filename);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $originalFilePath = public_path($sessionImage->original_file_url);
                    if (file_exists($originalFilePath)) {
                        unlink($originalFilePath);
                    }
                }
            }
        }

        session()->forget('cart');
        session()->put('image_quantity', 0);

        return redirect()->back()->with('success', 'All items removed from cart.');
    }

    public function update_cart_grand_total(Request $request)
    {
        // if(!Auth::check()){
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'User not authenticated. Please login to continue.'
        //     ]);
        // }
        session()->forget('cart_grand_total');
        session()->forget('gift_card_applied');
        // session()->forget('shipping');

        $grandTotal = $request->input('grand_total');
        $giftCard = $request->input('gift_card');
        // $shipping = $request->input('shipping');

        // Get existing cart session
        $sessionCart = session()->get('cart', []);

        // Add grand total to session cart
        session()->put('cart_grand_total', $grandTotal);
        session()->put('gift_card_applied', $giftCard);
        // session()->put('shipping', $shipping);

        return response()->json([
            'success' => true,
            'message' => 'Grand total updated in cart session.'
        ]);
    }

    public function order_summary()
    {
        $cart = session()->get('cart', []); // Product details
        $cartGrandTotal = floatval(session()->get('cart_grand_total', 0)); // Total price
        $giftCard = 0; // Gift card (optional)
        // $giftCard = session()->get('gift_card_applied', 0); // Gift card (optional)
        $shipping = floatval(get_setting('shipping_price')) ?? 0; // Gift card (optional)

        $shipping_address = ShippingAddress::where('user_id', Auth::user()->id ?? null)
            ->where('default_address', 1)
            ->first();

        if ($shipping_address) {
            $address = [
                'full_name' => $shipping_address->recipient_name ?? '',
                'phone_number' => $shipping_address->phone ?? '',
                'email' => $shipping_address->email ?? '',
                'pincode' => $shipping_address->pin_code ?? '',
                'address_line1' => $shipping_address->address_line1 ?? '',
                'address_line2' => $shipping_address->address_line2 ?? '',
                'state' => $shipping_address->state ?? '',
                'city' => $shipping_address->city ?? '',
                'alternate_phone_number' => $shipping_address->alt_phone ?? '',
            ];
            Session::forget('user_address');

            // Save to session (you can also save to database if needed)
            Session::put('user_address', $address);
        }

        // Example: Assume you set coupon data in session somewhere earlier
        $appliedCoupon = session()->get('applied_coupon', [
            'code' => null,
            'discount' => 0
        ]);

        return view('order_summary', compact('cart', 'cartGrandTotal', 'giftCard', 'appliedCoupon', 'shipping_address', 'shipping'));
    }

    public function place_order(Request $request)
    {
        $get_address = session('user_address');
        $get_city = City::find($get_address['city']);

        // Fetch cart items (assuming cart stored in session)
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        // Calculate total price
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['price'] * $product['quantity'];
        }

        // Apply coupon if exists
        $couponDiscount = 0;
        if (Session::has('applied_coupon')) {
            $coupon = Session::get('applied_coupon');
            $couponDiscount = $coupon['discount'] ?? 0;
            $code = $coupon['code'];
        }else{
            $code = null;
            $couponDiscount = null;
        }

        // Gift Card (optional, if you are using it)
        $giftCardDiscount = session()->get('gift_card', 0);

        $shipping = $request->input('shipping') ?? 0;
        if ($shipping == null) {
            $shipping = $get_city->shipping;
        }

        // Grand Total Calculation
        $grandTotal = ($subTotal + $giftCardDiscount + $shipping) - $couponDiscount;

        $user = User::where('email', $get_address['email'])->first();

        if(Auth::check()){
            $user = auth()->user();
        }

        if ($user) {
            // Update existing user
            // $user->name = $get_address['full_name'];
            // $user->phone = $get_address['phone_number'];
            // $user->save();
        } else {
            // Create new user
            $user = new User();
            $user->name = $get_address['full_name'];
            $user->email = $get_address['email'];
            $user->phone = $get_address['phone_number'];
            $user->password = bcrypt($get_address['password']);  // Set default password (optional)
            $user->status = 0; // Assuming 1 is for active
            $user->role = 'user'; // Assuming you have a role column
            $user->save();

            do {
                $otp = rand(100000, 999999);
                $exists = User::where('otp', $otp)->exists();
            } while ($exists);

            // Save OTP with expiration time
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            Mail::to($user->email)->send(new OtpMail($otp, $user->name));
        }


        // Create order
        $order = new Order();
        $order->user_id = $user->id;  // or $request->user_id if guest user
        $order->status = 'ordered';
        $order->total_amount = $grandTotal;
        $order->payment_method = $request->input('payment_method', 'cod');
        $order->payment_id = $request->input('razorpay_payment_id'); // Save this
        $order->coupon = $code;
        $order->discount = $couponDiscount;
        $order->shipping = $shipping;
        $order->gift = $giftCardDiscount;
        $order->save();

        $address = new Address();
        $address->order_id = $order->id;
        $address->user_id = $user->id;
        $address->full_name = $get_address['full_name'];
        $address->phone_number = $get_address['phone_number'];
        $address->email = $get_address['email'];
        $address->pincode = $get_address['pincode'];
        $address->address_line1 = $get_address['address_line1'];
        $address->address_line2 = $get_address['address_line2'];
        $address->city = $get_city->name;
        $address->alternate_phone_number = $get_address['alternate_phone_number'];
        $address->save();

        ShippingAddress::where('user_id', $user->id)->update(['default_address' => 0]);

        $shippingAddress = ShippingAddress::updateOrCreate(
            ['email' => $get_address['email']], // Search condition
            [
                'user_id' => $user->id,
                'recipient_name' => $get_address['full_name'],
                'phone' => $get_address['phone_number'],
                'pin_code' => $get_address['pincode'],
                'address_line1' => $get_address['address_line1'],
                'address_line2' => $get_address['address_line2'],
                'city' => $get_address['city'],
                'state' => $get_address['state'],
                'alt_phone' => $get_address['alternate_phone_number'],
                'default_address' => 1,
            ]
        );

        // Store each cart item into order_items
        foreach ($cart as $productId => $product) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product['product_id'];
            $orderItem->quantity = $product['quantity'];
            $orderItem->price = $product['price'];
            $orderItem->save();

        }

        $order = Order::with(['orderItems.product', 'user', 'address'])->findOrFail($order->id);
        $admin_email = get_setting('contact_email', 'support@magentickphotoframes.com');

        // Send order confirmation to user
        Mail::to($user->email)->send(new OrderPlacedUserMail($order));

        // Send order notification to admin
        Mail::to(env('MAIL_USERNAME'))->send(new OrderPlacedAdminMail($order));

        // Clear cart and session items after order placed
        session()->forget(['cart', 'applied_coupon', 'gift_card_applied', 'user_address']);

        $deleted = SessionImage::where('session_id', session()->getId())
            ->delete();

        // return redirect()->route('home')->with('success', 'Order placed successfully!');
        return response()->json(['success' => true, 'message' => 'Order placed successfully!']);
    }


    public function add_address(Request $request)
    {
        $passwordRule = Auth::check() ? 'nullable|min:6' : 'required|min:6';

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'email' => 'required|email',
            'password' => $passwordRule,
            'pincode' => 'required|digits:6',
            'address_line1' => 'required|string|max:500',
            'address_line2' => 'nullable|string|max:500',
            'state' => 'required',
            'city' => 'required',
            'state_name' => 'nullable|string|max:255', // added
            'city_name' => 'nullable|string|max:255',  // added
            'alternate_phone_number' => ['nullable', 'regex:/^\+?[0-9]{10,15}$/'],
        ]);

        // 🔹 Handle "Other" for State
        if ($request->state === 'other') {
            if (!$request->filled('state_name')) {
                return response()->json([
                    'error' => true,
                    'message' => 'Please enter state name if you choose Other.'
                ]);
            }

            // Save to states table (optional)
            $state = State::create(['name' => $request->state_name]);
            $validated['state'] = $state->id;
        }

        // 🔹 Handle "Other" for City
        if ($request->city === 'other') {
            if (!$request->filled('city_name')) {
                return response()->json([
                    'error' => true,
                    'message' => 'Please enter city name if you choose Other.'
                ]);
            }

            // Save to cities table (optional)
            $city = City::create([
                'name' => $request->city_name,
                'state_id' => $validated['state'], // link to selected/created state
                'shipping' => 0, // default, adjust if needed
            ]);
            $validated['city'] = $city->id;
        }

        $message = '';
        if(!Auth::check()){
            $existUser = User::where('email', $request->email)->first();
            if($existUser){
                return response()->json([
                    'error' => true,
                    'type' => 'email_exists',
                    'email' => $request->email,
                    'message' => 'Entered email exists, please log in'
                ]);
            }
            $message = "Address and account saved successfully!";
        }else{
            $message = "Address saved successfully!";
        }

        Session::forget('user_address');

        // Save to session (you can also save to database if needed)
        Session::put('user_address', $validated);

        return response()->json([
            'success' => true,
            'address' => $validated,
            'message' => $message
        ]);
    }

    public function upload_images(Request $request)
    {
        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $imageData = [];
        $uploadPath = public_path('uploads/collections_gallery/');

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = uniqid('img_') . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $imageName);
                $imagePath = 'uploads/collections_gallery/' . $imageName;

                $clusterImage = ClusterImage::create([
                    'cluster_id' => 1,
                    'image_path' => $imagePath
                ]);

                // Store in session to isolate uploads by user
                session()->push('uploaded_cluster_image_ids', $clusterImage->id);

                $imageData[] = [
                    'id' => $clusterImage->id,
                    'image_path' => asset($imagePath),
                ];
            }
        }

        return response()->json(['success' => true, 'images' => $imageData]);
    }

    public function delete_images(Request $request)
    {
        $images = ClusterImage::where('id', $request->image_id)->get();
        foreach ($images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
            $image->delete();
        }

        // Remove from session
        $uploaded = session()->get('uploaded_cluster_image_ids', []);
        if (($key = array_search($request->image_id, $uploaded)) !== false) {
            unset($uploaded[$key]);
            session()->put('uploaded_cluster_image_ids', array_values($uploaded));
        }

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function fetch_images(Request $request)
    {
        $uploadedIds = session()->get('uploaded_cluster_image_ids', []);
        $images = ClusterImage::whereIn('id', $uploadedIds)->get();

        return response()->json(['success' => true, 'data' => $images]);
    }

    public function states()
    {
        $states = State::select('id', 'name')->get();

        return response()->json(['success' => true, 'data' => $states]);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->select('id', 'name', 'shipping')->get();

        return response()->json(['success' => true, 'data' => $cities]);
    }

    public function getFrameDefaults()
    {
        $finish = Finish::where('status', '1')->first();
        $led = Led::where('status', '1')->first();
        $color = CustomColor::where('status', 1)->first();
        $size = Sizes::where('status', '1')->first();

        $defaults = [
            'design' => [
                'designClass' => 'classic-card-design',
                'displayText' => 'Border',
                'design_price' => 0,
            ],
            'color' => [
                'img_src' => asset($color->frame_img),
                'color_name' => $color->name,
                'shadowClass' => 'box-shadow-black', // adjust based on color if needed
                'color_price' => $color->price,
            ],
            'size' => [
                'width' => $size->width,
                'height' => $size->height,
                'max_width' => '500px',
                'frame_price' => $size->price,
                'frameSizeText' => $size->label,
            ],
            'finish' => [
                'finish_price' => $finish->price,
                'frameFinishText' => $finish->label,
            ],
            'led' => [
                'price' => $led->price,
                'value' => $led->name,
                'framehangText' => $led->name,
            ],
        ];

        return response()->json($defaults);
    }
}
