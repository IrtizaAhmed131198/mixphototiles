<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Finish;

class FinishController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            return view('profile.finish');
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = Finish::all();

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('action', function ($finish) {
                return '<button class="btn btn-sm btn-brand-dark edit-finish" data-id="'.$finish->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-finish" data-id="'.$finish->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'label'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new finish entry (assuming you have a finish model)
        $finish = new Finish();
        $finish->label = $request->label;
        $finish->price = $request->price;
        $finish->status = $request->status;
        $finish->save();

        // Return success response
        return response()->json(['success' => true, 'message' => 'Finish added successfully']);
    }

    public function edit($id)
    {
        $finish = Finish::findOrFail($id);
        return response()->json([
            'success' => true,
            'finish' => $finish
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'label'       => 'required|string|max:255',
            'price'      => 'required|numeric|min:0',
            'status'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the existing color record
        $finish = Finish::findOrFail($id);

        // Update other fields
        $finish->label = $request->label;
        $finish->price = $request->price;
        $finish->status = $request->status;

        $finish->save();

        return response()->json(['success' => true, 'message' => 'Finish updated successfully']);
    }

    public function destroy($id)
    {
        // Find the color entry by ID
        $finish = Finish::findOrFail($id);
        // Delete the color entry from the database
        if ($finish->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Finish deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete finish'
            ]);
        }
    }
}
