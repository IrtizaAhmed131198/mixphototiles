<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Settings;

class SettingController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('home')->with('error', 'You must be logged in to access this page.');
        }

        if(in_array(Auth::user()->role, ['super_admin'])) {
            $settings = Settings::all();
            return view('profile.settings', compact('settings'));
        }else{
            abort(403);
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        // Fetch all settings from the database
        $settings = Settings::all();

        // Define validation rules based on setting type
        $rules = [];
        foreach ($settings as $setting) {
            if ($setting->type === 'file') {
                $rules[$setting->name] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'; // Adjust file types and size as needed
            } elseif ($setting->type === 'number') {
                $rules[$setting->name] = 'nullable|numeric';
            } else {
                $rules[$setting->name] = 'nullable|string';
            }
        }

        // Validate the request
        $validatedData = $request->validate($rules);

        // Process and update settings
        foreach ($settings as $setting) {
            if ($setting->type == 'file' && $request->hasFile($setting->name)) {
                // Store file
                $filePath = $request->file($setting->name)->store('uploads/settings', 'public');

                // Delete the old file if it exists
                if ($setting->value) {
                    \Storage::disk('public')->delete($setting->value);
                }

                $setting->update(['value' => $filePath]);
            } else {
                $setting->update(['value' => $validatedData[$setting->name] ?? null]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
