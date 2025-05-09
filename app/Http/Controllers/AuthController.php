<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Mail\AccountVerified;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create user in the database
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'role' => 'user',
                'password' => bcrypt(str()->random(16)), // Random password as it's social login
                'status' => 1
            ]);

            // Store user in session
            Session::put('google_user', $user);

            Auth::login($user);

            return redirect()->route('profile')->with('success', 'Google login successful!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to login with Google.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'emailOrMobile' => 'required',
            'password' => 'required',
        ]);

        // Determine whether it's an email or a mobile number
        $loginKey = filter_var($request->emailOrMobile, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $credentials = [
            $loginKey => $request->emailOrMobile,
            'password' => $request->password,
        ];

        // Check if the user exists
        $user = User::where($loginKey, $request->emailOrMobile)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'The account does not exist, please signup.'
            ], 404);
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user's status is 1 (active)
            if ($user->status !== 1) {
                Auth::logout(); // Log out if status is not 1
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your Email'
                ], 403);
            }

            // If status is 1, return success
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'url' => route('profile')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|unique:users,phone|regex:/^[0-9]{10,15}$/',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 0
        ]);

        // Generate a unique OTP
        do {
            $otp = rand(100000, 999999);
            $exists = User::where('otp', $otp)->exists();
        } while ($exists);

        // Save OTP with expiration time
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully! Please verify your email.',
            'email' => $user->email
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Email not found.'], 404);
        }

        // Generate a unique OTP
        do {
            $otp = rand(100000, 999999);
            $exists = User::where('otp', $otp)->exists();
        } while ($exists);

        // Save OTP with expiration time
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Send OTP via email
        // Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
        //     $message->to($user->email)->subject('Password Reset OTP');
        // });
        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        return response()->json(['status' => 'success', 'message' => 'OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $user = User::where('otp', $request->otp)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP.'], 400);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['status' => 'error', 'message' => 'OTP expired.'], 400);
        }

        // OTP Verified, clear OTP fields
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->status = 1; // Activate user
        $user->save();

        // Send verification email
        Mail::to($user->email)->send(new AccountVerified($user, $request->password));

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified. Proceed to reset your password.',
            'email' => $user->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 400);
        }

        // Update password
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Password reset successfully. Please login with your new password.']);
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('google_user');
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
