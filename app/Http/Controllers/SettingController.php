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

        $rules = Settings::pluck('name')->mapWithKeys(function ($name) {
            return [$name => 'nullable|string'];
        })->toArray();

        $request->validate($rules);

        foreach ($request->except('_token', '_method') as $name => $value) {
            $setting = Settings::where('name', $name)->first();

            if ($setting) {
                if ($setting->type == 'file' && $request->hasFile($name)) {
                    // Store file in the storage folder
                    $filePath = $request->file($name)->store('uploads/settings', 'public');

                    // Delete the old file if it exists
                    if ($setting->value) {
                        \Storage::disk('public')->delete($setting->value);
                    }

                    $setting->update(['value' => $filePath]);
                } else {
                    $setting->update(['value' => $value]);
                }
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
