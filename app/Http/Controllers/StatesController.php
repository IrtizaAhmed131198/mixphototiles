<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\State;

class StatesController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.states');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = State::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function ($states) {
                return '<button class="btn btn-sm btn-brand-dark edit-states" data-id="'.$states->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-states" data-id="'.$states->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $states = new State();
        $states->name = $request->name;
        $states->save();

        return response()->json(['success' => true, 'message' => 'State added successfully']);
    }


    public function edit($id)
    {
        $states = State::findOrFail($id);
        return response()->json([
            'success' => true,
            'states' => $states
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $states = State::findOrFail($id);
        $states->name = $request->name;
        $states->save();

        return response()->json(['success' => true, 'message' => 'State updated successfully']);
    }


    public function destroy($id)
    {
        $state = State::findOrFail($id);

        // Delete all related cities
        $state->cities()->delete();

        // Then delete the state itself
        if ($state->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'State and related cities deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete State'
            ]);
        }
    }
}
