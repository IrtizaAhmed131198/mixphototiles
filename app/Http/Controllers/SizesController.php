<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Sizes;

class SizesController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.sizes');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = Sizes::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('image', function ($row) {
                // Return the full image URL for the image
                return '<img src="' . asset($row->image) . '" alt="Image" style="max-width: 100px;">';
            })
            ->addColumn('action', function ($sizes) {
                return '<button class="btn btn-sm btn-primary edit-sizes" data-id="'.$sizes->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-sizes" data-id="'.$sizes->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action', 'image']) // Add 'img' and 'image' to rawColumns
            ->make(true);
    }



    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'label'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required',
            'width' => 'required|string',
            'height' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store images in the public path
        if ($request->hasFile('image')) {
            $size_image = $request->file('image');
            $sizeImgPath = time() . '_sizes.' . $size_image->getClientOriginalExtension();
            $size_image->move(public_path('uploads/size_images'), $sizeImgPath);
            $sizeImgFullPath = 'uploads/size_images/' . $sizeImgPath;
        }

        // Create a new color entry (assuming you have a Color model)
        $sizes = new Sizes();
        $sizes->label = $request->label;
        $sizes->price = $request->price;
        $sizes->image = $sizeImgFullPath ?? null;
        $sizes->status = $request->status;
        $sizes->width = $request->width;
        $sizes->height = $request->height;
        $sizes->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Size added successfully']);
    }

    public function edit($id)
    {
        $sizes = Sizes::findOrFail($id);
        return response()->json([
            'success' => true,
            'sizes' => $sizes
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'label'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required',
            'width' => 'required|string',
            'height' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the existing color record
        $sizes = Sizes::findOrFail($id);

        // Delete previous image if new image is uploaded
        if ($request->hasFile('image')) {
            if (!empty($sizes->image) && file_exists(public_path($sizes->image))) {
                unlink(public_path($sizes->image)); // Delete old file
            }
            $size_image = $request->file('image');
            $sizeImgPath = time() . '_sizes.' . $size_image->getClientOriginalExtension();
            $size_image->move(public_path('uploads/size_images'), $sizeImgPath);
            $sizes->image = 'uploads/size_images/' . $sizeImgPath;
        }else {
            // Keep existing
            $sizes->image = $request->existing_size_image;
        }

        // Update other fields
        $sizes->label = $request->label;
        $sizes->price = $request->price;
        $sizes->status = $request->status;
        $sizes->width = $request->width;
        $sizes->height = $request->height;

        $sizes->save();

        return response()->json(['success' => true, 'message' => 'Size updated successfully']);
    }

    public function destroy($id)
    {
        // Find the sizes entry by ID
        $sizes = Sizes::findOrFail($id);

        // Delete image if it exists
        if (!empty($sizes->image) && file_exists(public_path($sizes->image))) {
            unlink(public_path($sizes->image));
        }

        // Delete the sizes entry from the database
        if ($sizes->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Size deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete size'
            ]);
        }
    }
}
