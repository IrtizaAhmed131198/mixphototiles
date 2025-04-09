<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    public function profile()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.myprofile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
            'dob' => 'required|date',
            'gender' => 'required'
        ]);

        Auth::user()->update($request->all());

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function orders()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.order');
    }

    public function getOrders()
    {
        $orders = Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->latest();

        return DataTables::of($orders)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('title', function ($order) {
                return $order->orderItems->pluck('product.name')->implode(', ');
            })
            ->addColumn('price', function ($order) {
                return number_format($order->total_amount, 2);
            })
            ->addColumn('status', function ($order) {
                return ucfirst($order->status);
            })
            ->addColumn('payment_method', function ($order) {
                return strtoupper($order->payment_method);
            })
            ->addColumn('coupon', function ($order) {
                return $order->coupon ?? '-';
            })
            ->addColumn('discount', function ($order) {
                return $order->discount ?? '-';
            })
            ->addColumn('shipping', function ($order) {
                return $order->shipping ?? '-';
            })
            ->addColumn('datetime', function ($order) {
                return $order->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($order) {
                return '<a href="'.route('orders.view', $order->id).'" class="btn btn-sm btn-info">View</a>';
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }

    public function viewOrder($id)
    {
        $order = Order::with(['orderItems.product'])->where('user_id', Auth::id())->findOrFail($id);

        return view('profile.receipt', compact('order'));
    }

    public function address()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin'){
            return redirect()->route('home')->with('error', 'You are not allowed to access this page.');
        }

        $data = ShippingAddress::all();

        return view('profile.address', compact('data'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'pin_code' => 'required',
            'address1' => 'required',
            'address2' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'alt_phone' => 'nullable',
            'default_address' => 'nullable|boolean',
        ]);

        // Set other addresses as non-default if this one is marked default
        // if ($request->default_address) {
        //     ShippingAddress::where('user_id', Auth::id())->update(['default_address' => false]);
        // }

        ShippingAddress::create([
            'user_id' => Auth::user()->id,
            'recipient_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pin_code' => $request->pin_code,
            'address_line1' => $request->address1,
            'address_line2' => $request->address2,
            'state' => $request->state,
            'city' => $request->city,
            'alt_phone' => $request->alt_phone,
            'default_address' => $request->default_address ? true : false,
        ]);

        return back()->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'pin_code' => 'required',
            'address1' => 'required',
            'address2' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'alt_phone' => 'nullable',
            'default_address' => 'nullable|boolean',
        ]);

        $address = ShippingAddress::findOrFail($id);

        // Set other addresses as non-default if this one is marked default
        if ($request->default_address) {
            ShippingAddress::where('user_id', Auth::id())->update(['default_address' => false]);
        }

        $address->update([
            'recipient_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pin_code' => $request->pin_code,
            'address_line1' => $request->address1,
            'address_line2' => $request->address2,
            'state' => $request->state,
            'city' => $request->city,
            'alt_phone' => $request->alt_phone,
            'default_address' => $request->default_address ? true : false,
        ]);

        return back()->with('success', 'Address updated successfully!');
    }

    public function deleteAddress($id)
    {
        $address = ShippingAddress::findOrFail($id);
        $userId = Auth::user()->id; // Ensure only user's own address is deleted

        // Check if the deleted address is the default one
        $wasDefault = $address->default_address == 1;

        // Delete the address
        $address->delete();

        // If it was the default, assign a new default
        if ($wasDefault) {
            $nextAddress = ShippingAddress::where('user_id', $userId)->first();
            if ($nextAddress) {
                $nextAddress->default_address = 1;
                $nextAddress->save();
            }
        }

        return response()->json(['message' => 'Address deleted successfully!']);
    }

    public function setDefault(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $addressId = $request->id;
        $userId = Auth::user()->id; // Ensure user is updating their own addresses

        // Set all addresses of the user to default_address = 0
        ShippingAddress::where('user_id', $userId)->update(['default_address' => 0]);

        // Set the selected address to default_address = 1
        $address = ShippingAddress::where('id', $addressId)->where('user_id', $userId)->first();

        if ($address) {
            $address->default_address = 1;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Default address updated successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Address not found.',
        ], 404);
    }

    public function resetpassword()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.resetpassword');
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
