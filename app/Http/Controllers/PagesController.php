<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function privacy()
    {
        return view('privacy');
    }

    public function refund()
    {
        return view('refund');
    }

    public function shipping()
    {
        return view('shipping');
    }

    public function terms()
    {
        return view('terms');
    }
}
