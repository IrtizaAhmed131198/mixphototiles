<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(Auth::user()->role == 'super_admin') {
            $title = 'Admin/User';
            return view('profile.admin', compact('title'));
        } elseif(Auth::user()->role == 'admin') {
            $title = 'User';
            return view('profile.admin', compact('title'));
        }else{
            abort(403);
        }

    }

    public function getData()
    {
        $query = User::query();

        // Exclude super_admin role for all users
        $query->where('role', '!=', 'super_admin');

        // If the authenticated user is an admin, exclude other admin users
        if (Auth::user()->role == 'admin') {
            $query->where('role', '!=', 'admin');
        }

        return DataTables::of($query)
            ->addColumn('id', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('status', function ($row) {
                return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('login_as', function ($user) {
                if (Auth::user()->role === 'super_admin' && $user->status == 1) {
                    $route = route('admin.login.as', ['id' => $user->id]);
                    return '<a href="'.$route.'" class="btn btn-sm btn-info">Login As</a>';
                }
                return '';
            })
            ->addColumn('action', function ($user) {
                return '<button class="btn btn-sm btn-brand-dark edit-user" data-id="'.$user->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-user" data-id="'.$user->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'status', 'action', 'login_as']) // Include 'status' here to allow HTML badges
            ->make(true);
    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'role' => 'required|in:admin,user',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->password = Hash::make($request->password); // Hash the password

        $user->save(); // Save the user to the database

        // Redirect back with success message
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'required|string',
            'role' => 'required|in:admin,user',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        $user->status = $request->input('status');

        // Only update password if it's not empty
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the user exists
        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ]);
        }
    }

    public function loginAsUser($id)
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->status != 1) {
            return redirect()->back()->with('error', 'Cannot login as inactive user.');
        }

        Auth::logout(); // logout current super_admin
        Auth::login($user); // login as selected user

        return redirect()->route('profile'); // change to whatever route you want to redirect to
    }

}
