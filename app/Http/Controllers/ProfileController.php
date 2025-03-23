<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends Controller
{
    public function profile()
    {
        if (!$this->checkCustomAuth()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.myprofile');
    }

    public function orders()
    {
        if (!$this->checkCustomAuth()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.order');
    }

    public function address()
    {
        if (!$this->checkCustomAuth()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.address');
    }

    public function resetpassword()
    {
        if (!$this->checkCustomAuth()) {
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        return view('profile.resetpassword');
    }


    private function checkCustomAuth()
    {
        return session()->has('user_id'); // Modify this according to your custom auth logic
    }
}
