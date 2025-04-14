<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.coupon');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = Coupon::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function ($coupon) {
                return '<button class="btn btn-sm btn-primary edit-coupon" data-id="'.$coupon->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-coupon" data-id="'.$coupon->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'            => 'required|string|max:255|unique:coupon,code',
            'discount_amount' => 'required|numeric|min:0',
            'date_range'      => 'required|string', // or use 'array' if you store as JSON
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->date_range = $request->date_range;
        $coupon->title = $request->title;
        $coupon->description = $request->description;
        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Coupon added successfully']);
    }


    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json([
            'success' => true,
            'coupon' => $coupon
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code'            => 'required|string|max:255|unique:coupon,code,' . $id,
            'discount_amount' => 'required|numeric|min:0',
            'date_range'      => 'required|string',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->code = $request->code;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->date_range = $request->date_range;
        $coupon->title = $request->title;
        $coupon->description = $request->description;
        $coupon->save();

        return response()->json(['success' => true, 'message' => 'Coupon updated successfully']);
    }


    public function destroy($id)
    {
        // Find the color entry by ID
        $coupon = Coupon::findOrFail($id);
        // Delete the color entry from the database
        if ($coupon->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Coupon'
            ]);
        }
    }
}
