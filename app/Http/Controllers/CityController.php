<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\State;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            $states = State::all();
            return view('profile.city', compact('states'));
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = City::with('state')->get();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function ($city) {
                return '<button class="btn btn-sm btn-brand-dark edit-city" data-id="'.$city->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-city" data-id="'.$city->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
            'name' => 'required',
            'shipping' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city = new City();
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->shipping = $request->shipping;
        $city->save();

        return response()->json(['success' => true, 'message' => 'City added successfully']);
    }


    public function edit($id)
    {
        $city = City::with('state')->where('id', $id)->first();
        return response()->json([
            'success' => true,
            'city' => $city
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required',
            'name' => 'required',
            'shipping' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $city = City::findOrFail($id);
        $city->state_id = $request->state_id;
        $city->name = $request->name;
        $city->shipping = $request->shipping;
        $city->save();

        return response()->json(['success' => true, 'message' => 'City updated successfully']);
    }


    public function destroy($id)
    {
        // Find the color entry by ID
        $city = City::findOrFail($id);
        // Delete the color entry from the database
        if ($city->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'City deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete City'
            ]);
        }
    }
}
