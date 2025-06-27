<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        $title = 'Contact Users';

        return view('contact.index', compact('title'));

    }

    public function get()
    {
        $query = Contact::query();

        return DataTables::of($query)
            ->addIndexColumn() // Automatically adds row index (1,2,3,...)
            // ->addColumn('action', function ($contact) {
            //     return '<button class="btn btn-sm btn-brand-dark edit-contact" data-id="' . $contact->id . '">Edit</button>
            //             <button class="btn btn-sm btn-brand-dark delete-contact" data-id="' . $contact->id . '">Delete</button>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }
}
