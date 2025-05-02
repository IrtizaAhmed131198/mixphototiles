<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Led;

class LedController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.led');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = Led::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('image', function ($row) {
                // Return the full image URL for the option_img
                return '<img src="' . asset($row->image) . '" alt="Image" style="max-width: 100px;">';
            })
            ->addColumn('action', function ($led) {
                return '<button class="btn btn-sm btn-brand-dark edit-led" data-id="'.$led->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-led" data-id="'.$led->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action', 'image'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required|boolean',
            'image' => 'required|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $led = new Led();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ledImgPath = time() . '_led.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/led_images'), $ledImgPath);
            $ledImgFullPath = 'uploads/led_images/' . $ledImgPath;
        }
        $led->name = $request->name;
        $led->price = $request->price;
        $led->image = $ledImgFullPath ?? null;
        $led->status = $request->status;
        $led->save();

        return response()->json(['success' => true, 'message' => 'Led added successfully']);
    }


    public function edit($id)
    {
        $led = Led::findOrFail($id);
        return response()->json([
            'success' => true,
            'led' => $led
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required|boolean',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $led = Led::findOrFail($id);

        if ($request->hasFile('image')) {
            if (!empty($led->image) && file_exists(public_path($led->image))) {
                unlink(public_path($led->image)); // Delete old file
            }
            $image = $request->file('image');
            $ledImgPath = time() . '_led.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/led_images'), $ledImgPath);
            $led->image = 'uploads/led_images/' . $ledImgPath;
        }else {
            // Keep existing
            $led->image = $request->existing_img;
        }

        $led->name = $request->name;
        $led->price = $request->price;
        $led->status = $request->status;
        $led->save();

        return response()->json(['success' => true, 'message' => 'Led updated successfully']);
    }


    public function destroy($id)
    {
        // Find the color entry by ID
        $led = Led::findOrFail($id);
        // Delete the color entry from the database
        if ($led->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Led deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Led'
            ]);
        }
    }
}
