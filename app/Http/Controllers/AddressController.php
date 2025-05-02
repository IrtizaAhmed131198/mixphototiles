<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ShippingAddress;

class AddressController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin'){
            return view('profile.shipping_address');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = ShippingAddress::with('user', 'state', 'city')->get();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function ($address) {
                return '<button class="btn btn-sm btn-brand-dark edit-address" data-id="'.$address->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-address" data-id="'.$address->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action']) // Add 'img' and 'image' to rawColumns
            ->make(true);
    }

    public function edit($id)
    {
        $address = ShippingAddress::findOrFail($id);
        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'pin_code' => 'required',
            'address1' => 'required',
            'address2' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'alt_phone' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the existing color record
        $address = ShippingAddress::findOrFail($id);

        // Update other fields
        $address->recipient_name = $request->name;
        $address->phone = $request->phone;
        $address->email = $request->email;
        $address->pin_code = $request->pin_code;
        $address->address_line1 = $request->address1;
        $address->address_line2 = $request->address2;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->alt_phone = $request->alt_phone;

        $address->save();

        return response()->json(['success' => true, 'message' => 'Shipping Address updated successfully']);
    }

    public function destroy($id)
    {
        // Find the address entry by ID
        $address = ShippingAddress::findOrFail($id);

        // Delete the address entry from the database
        if ($address->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Shipping Address deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete address'
            ]);
        }
    }
}
