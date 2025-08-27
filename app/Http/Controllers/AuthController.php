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
use App\Jobs\SendOtpEmailJob;

class AuthController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('redirect_to')) {
            session(['google_redirect_to' => $request->input('redirect_to')]);
        }

        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'role' => 'user',
                'password' => bcrypt(str()->random(16)),
                'status' => 1
            ]);

            Session::put('google_user', $user);

            Auth::login($user);

            // Get intended URL or default to profile
            $redirectUrl = session('google_redirect_to', route('profile'));

            // Clear the session variable to avoid using it again accidentally
            session()->forget('google_redirect_to');

            return redirect($redirectUrl)->with('success', 'Google login successful!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Failed to login with Google.');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'emailOrMobile' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->emailOrMobile,
            'password' => $request->password,
        ];

        $user = User::where('email', $request->emailOrMobile)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'The account does not exist, please signup.'
            ], 404);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status !== 1) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your Email'
                ], 403);
            }

            // Use provided redirect URL or fallback to profile
            $redirectUrl = $request->input('redirect_to') ?? route('profile');

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'url' => $redirectUrl
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

        // Dispatch job to queue instead of sending immediately
        dispatch(new SendOtpEmailJob($otp, $user->email, $user->name));

        // Send OTP via email
        // Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
        //     $message->to($user->email)->subject('Password Reset OTP');
        // });
        // Mail::to($user->email)->send(new OtpMail($otp, $user->name));


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
