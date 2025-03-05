<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile() {
        return view('profile.myprofile');
    }


    public function orders() {
        return view('profile.order');
    }


    public function address() {
        return view('profile.address');
    }


    public function resetpassword() {
        return view('profile.resetpassword');
    }
}
