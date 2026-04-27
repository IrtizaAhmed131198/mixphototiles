<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomColor;

class CustomColorController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.colors');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = CustomColor::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('option_img', function ($row) {
                // Return the full image URL for the option_img
                return '<img src="' . asset($row->option_img) . '" alt="Option Image" style="max-width: 100px;">';
            })
            ->addColumn('frame_img', function ($row) {
                // Return the full image URL for the frame_img
                return '<img src="' . asset($row->frame_img) . '" alt="Frame Image" style="max-width: 100px;">';
            })
            ->addColumn('price', function ($row) {
                return (int) round($row->price);
            })
            ->addColumn('action', function ($color) {
                return '<button class="btn btn-sm btn-brand-dark edit-color" data-id="'.$color->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-color" data-id="'.$color->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action', 'option_img', 'frame_img']) // Add 'option_img' and 'frame_img' to rawColumns
            ->make(true);
    }



    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required|boolean',
            'option_img' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            'frame_img'  => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048', // Max 2MB
            'before_color_code' => 'required|string',
            'after_color_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store images in the public path
        if ($request->hasFile('option_img')) {
            $option_img = $request->file('option_img');
            $optionImgPath = time() . '_option.' . $option_img->getClientOriginalExtension();
            $option_img->move(public_path('uploads/option_imgs'), $optionImgPath);
            $optionImgFullPath = 'uploads/option_imgs/' . $optionImgPath;
        }

        if ($request->hasFile('frame_img')) {
            $frame_img = $request->file('frame_img');
            $frameImgPath = time() . '_frame.' . $frame_img->getClientOriginalExtension();
            $frame_img->move(public_path('uploads/frame_imgs'), $frameImgPath);
            $frameImgFullPath = 'uploads/frame_imgs/' . $frameImgPath;
        }

        // Create a new color entry (assuming you have a Color model)
        $color = new CustomColor();
        $color->name = $request->name;
        $color->price = $request->price;
        $color->option_img = $optionImgFullPath ?? null;
        $color->frame_img = $frameImgFullPath ?? null;
        $color->status = $request->status;
        $color->before_color_code = $request->before_color_code;
        $color->after_color_code = $request->after_color_code;
        $color->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Color added successfully']);
    }

    public function edit($id)
    {
        $color = CustomColor::findOrFail($id);
        return response()->json([
            'success' => true,
            'color' => $color
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required|boolean',
            'option_img' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'frame_img'  => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'before_color_code' => 'required|string',
            'after_color_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the existing color record
        $color = CustomColor::findOrFail($id);

        // Delete previous option image if new image is uploaded
        if ($request->hasFile('option_img')) {
            if (!empty($color->option_img) && file_exists(public_path($color->option_img))) {
                unlink(public_path($color->option_img)); // Delete old file
            }
            $option_img = $request->file('option_img');
            $optionImgPath = time() . '_option.' . $option_img->getClientOriginalExtension();
            $option_img->move(public_path('uploads/option_imgs'), $optionImgPath);
            $color->option_img = 'uploads/option_imgs/' . $optionImgPath;
        }else {
            // Keep existing
            $color->option_img = $request->existing_option_img;
        }

        // Delete previous frame image if new image is uploaded
        if ($request->hasFile('frame_img')) {
            if (!empty($color->frame_img) && file_exists(public_path($color->frame_img))) {
                unlink(public_path($color->frame_img)); // Delete old file
            }
            $frame_img = $request->file('frame_img');
            $frameImgPath = time() . '_frame.' . $frame_img->getClientOriginalExtension();
            $frame_img->move(public_path('uploads/frame_imgs'), $frameImgPath);
            $color->frame_img = 'uploads/frame_imgs/' . $frameImgPath;
        }else {
            $color->frame_img = $request->existing_frame_img;
        }

        // Update other fields
        $color->name = $request->name;
        $color->price = $request->price;
        $color->status = $request->status;
        $color->before_color_code = $request->before_color_code;
        $color->after_color_code = $request->after_color_code;

        $color->save();

        return response()->json(['success' => true, 'message' => 'Color updated successfully']);
    }

    public function destroy($id)
    {
        // Find the color entry by ID
        $color = CustomColor::findOrFail($id);

        // Delete option image if it exists
        if (!empty($color->option_img) && file_exists(public_path($color->option_img))) {
            unlink(public_path($color->option_img));
        }

        // Delete frame image if it exists
        if (!empty($color->frame_img) && file_exists(public_path($color->frame_img))) {
            unlink(public_path($color->frame_img));
        }

        // Delete the color entry from the database
        if ($color->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Color deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete color'
            ]);
        }
    }
}
