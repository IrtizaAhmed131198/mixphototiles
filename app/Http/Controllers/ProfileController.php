<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends Controller
{
    public function profile() {
        return view('profile.myprofile');
    }


    public function orders() {
        // $orders = Order::with('orderItems')->get();
        return view('profile.order');
    }


    public function address() {
        return view('profile.address');
    }


    public function resetpassword() {
        return view('profile.resetpassword');
    }
}
