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
        abort_unless(Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'], true), 403);
        $query = User::query();

        // Exclude super_admin role for all users
        $query->where('role', '!=', 'super_admin');

        // If the authenticated user is an admin, exclude other admin users
        if (Auth::user()->role == 'admin') {
            $query->where('role', '!=', 'admin');
        }

        return DataTables::of($query)
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('id_label', function ($row) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->editColumn('status', function ($row) {
                return $row->status;
            })
            ->addColumn('status_label', function ($row) {
                return $row->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
            })
            ->addColumn('login_as', function ($user) {
                if (Auth::user()->role !== 'super_admin') {
                    return '';
                }
                if ((int) $user->status !== 1) {
                    return '<button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Account is inactive">Login As</button>';
                }
                $route = e(route('admin.login.as', ['id' => $user->id]));
                $token = e(csrf_token());
                return '<form method="POST" action="'.$route.'" class="m-0">'
                    .'<input type="hidden" name="_token" value="'.$token.'">'
                    .'<button type="submit" class="btn btn-sm btn-brand-dark">Login As</button></form>';
            })
            ->addColumn('action', function ($user) {
                return '<button class="btn btn-sm btn-brand-dark edit-user" data-id="'.$user->id.'">Edit</button>
                        <button class="btn btn-sm btn-brand-dark delete-user" data-id="'.$user->id.'">Delete</button>';
            })
            ->rawColumns(['id', 'status', 'action', 'login_as', 'status_label', 'id_label']) // Include 'status' here to allow HTML badges
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

    public function loginAsUser(Request $request, $id)
    {
        $original = Auth::user();
        abort_unless($original && $original->role === 'super_admin' && (int) $original->status === 1, 403);
        abort_if($request->session()->has('impersonation'), 403, 'Return to your account before switching again.');

        $target = User::findOrFail($id);
        abort_unless(in_array($target->role, ['admin', 'user'], true), 403);
        if ((int) $target->status !== 1) {
            return redirect()->route('admin.index')->with('error', 'Cannot login as inactive user.');
        }

        // Preserve the original account's session without sharing its cart,
        // address, Google identity or checkout state with the target account.
        $originalSession = $request->session()->except([
            '_token', Auth::guard('web')->getName(), 'impersonation',
        ]);
        $impersonation = [
            'original_id' => $original->id,
            'target_id' => $target->id,
            'password_fingerprint' => hash('sha256', $original->getAuthPassword()),
            'original_session' => $originalSession,
        ];

        Auth::guard('web')->logoutCurrentDevice();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::guard('web')->login($target, false);
        $request->session()->put('impersonation', $impersonation);

        \Illuminate\Support\Facades\Log::info('Super admin impersonation started', [
            'original_id' => $original->id, 'target_id' => $target->id,
        ]);

        return redirect()->route('profile');
    }

    public function returnToSuperAdmin(Request $request)
    {
        $impersonation = $request->session()->get('impersonation');
        abort_unless(is_array($impersonation)
            && (int) ($impersonation['target_id'] ?? 0) === (int) Auth::id(), 403);

        $original = User::find($impersonation['original_id'] ?? null);
        abort_unless($original && $original->role === 'super_admin' && (int) $original->status === 1
            && hash_equals($impersonation['password_fingerprint'] ?? '', hash('sha256', $original->getAuthPassword())),
            403, 'The original super-admin account is no longer available. Please sign in again.');

        Auth::guard('web')->logoutCurrentDevice();
        $request->session()->invalidate();
        $request->session()->put($impersonation['original_session'] ?? []);
        $request->session()->regenerateToken();
        Auth::guard('web')->login($original, false);

        \Illuminate\Support\Facades\Log::info('Super admin impersonation ended', [
            'original_id' => $original->id, 'target_id' => $impersonation['target_id'],
        ]);

        return redirect()->route('admin.index')->with('success', 'You are back in your super-admin account.');
    }
}
