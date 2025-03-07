<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('profile.frames');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        // Directory to store images
        $uploadPath = public_path('uploads/frames');

        // Ensure directory exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Handle main image upload
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = uniqid('main_') . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move($uploadPath, $mainImageName);
            $mainImagePath = 'uploads/frames/' . $mainImageName;
        }

        // Save product to database
        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'image' => $mainImagePath,
            'status' => $request->status,
            'type' => 'collections',
        ]);

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $imageName = uniqid('additional_') . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/frames/' . $imageName,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function getData()
    {
        $products = Product::select('id', 'name', 'price', 'discount', 'image')
            ->where('type', 'collections');

        return DataTables::of($products)
            ->addColumn('id', function ($row) {
                // Add row counter
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('image', function ($product) {
                $url = asset($product->image);
                return '<img src="'.$url.'" alt="Product Image" width="50" height="50">';
            })
            ->addColumn('action', function ($product) {
                return '<button class="btn btn-sm btn-primary edit-frame" data-id="'.$product->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-product" data-id="'.$product->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'image', 'action'])
            ->make(true);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $additionalImages = ProductImage::where('product_id', $id)->get();

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price,
            'discount' => $product->discount,
            'status' => $product->status,
            'main_image' => asset($product->image),
            'additional_images' => $additionalImages->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset($image->image_path),
                ];
            })
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->status = $request->status;

        $uploadPath = public_path('uploads/frames');

        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = uniqid('main_') . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move($uploadPath, $mainImageName);
            $product->image = 'uploads/frames/' . $mainImageName;
        }

        // Handle Additional Images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $imageName = uniqid('additional_') . '.' . $image->getClientOriginalExtension();
                $image->move($uploadPath, $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'uploads/frames/' . $imageName,
                ]);
            }
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function deleteAdditionalImage($id)
    {
        $image = ProductImage::find($id);

        if ($image) {
            // Optionally delete the physical file
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ]);
        }

        // Delete main image file
        $mainImagePath = public_path('uploads/frames/' . $product->image);
        if (file_exists($mainImagePath)) {
            unlink($mainImagePath);
        }

        // Delete all additional images from database and storage
        $additionalImages = ProductImage::where('product_id', $id)->get();
        foreach ($additionalImages as $image) {
            $imagePath = public_path($image->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        // Delete the product record
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
