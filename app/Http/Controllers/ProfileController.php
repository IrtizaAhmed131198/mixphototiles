<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function address()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.address');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pin_code' => 'required|string|max:10',
            'address1' => 'required|string|max:500',
            'address2' => 'nullable|string|max:500',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
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
