<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadAcknowledgement;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Lead;

class WebsiteController extends Controller
{
    private function settings()
    {
        return SiteSetting::pluck('value', 'key')->toArray();
    }

    public function home()
    {
        $services = Service::where('active', true)->take(6)->get();
        $settings = $this->settings();
        return view('website.home', compact('services', 'settings'));
    }

    public function services()
    {
        $services = Service::where('active', true)->get();
        $settings = $this->settings();
        return view('website.services', compact('services', 'settings'));
    }

    public function about()
    {
        $settings = $this->settings();
        return view('website.about', compact('settings'));
    }

    public function contact()
    {
        $services = Service::where('active', true)->get();
        $settings = $this->settings();
        return view('website.contact', compact('services', 'settings'));
    }

    public function submitLead(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20|regex:/^[+0-9()\s-]{7,20}$/',
            'email'   => 'nullable|email',
            'service' => 'nullable|string',
            'message' => 'nullable|string|max:1000',
        ]);

        $lead = Lead::create($request->only(['name', 'phone', 'email', 'service', 'message']));

        // Automated acknowledgement — admin can turn it off in Site Settings.
        $autoReply = SiteSetting::where('key', 'auto_reply_enabled')->value('value');
        if ($lead->email && $autoReply !== '0') {
            try {
                Mail::to($lead->email)->send(new LeadAcknowledgement($lead));
            } catch (\Throwable $e) {
                Log::warning('Lead acknowledgement email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Thank you! We will contact you soon.');
    }
}
