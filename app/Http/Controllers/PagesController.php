<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdminMail;
use App\Mail\ContactUserMail;
use App\Models\Contact;

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

    public function faq()
    {
        abort(403);
        return view('faq');
    }

    public function contact()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'message' => 'nullable',
        ]);

        $data['ip'] = $request->ip();

        Contact::create($data);

        // Send to Admin
        Mail::to('support@magneticphotoframes.com')->send(new ContactAdminMail($data));

        // Send to User
        Mail::to($data['email'])->send(new ContactUserMail($data));

        return redirect()->route('contact')->with('success', 'Thank you for contacting us!');
    }
}
