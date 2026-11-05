<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate + whitelist: only these keys may ever reach site_settings.
        $data = $request->validate([
            'site_name'      => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'whatsapp'       => 'required|string|max:20|regex:/^\d+$/',
            'email'          => 'required|email|max:100',
            'address'        => 'required|string|max:255',
            'working_hours'  => 'nullable|string|max:100',
            'hero_title'     => 'required|string|max:150',
            'hero_subtitle'  => 'nullable|string|max:255',
            'about_text'     => 'nullable|string|max:2000',
            'auto_reply_enabled' => 'required|boolean',
            'auto_reply_subject' => 'nullable|string|max:150',
            'auto_reply_body'    => 'nullable|string|max:1000',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return back()->with('success', 'Settings saved successfully!');
    }
}
