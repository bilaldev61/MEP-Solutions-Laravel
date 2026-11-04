<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Employee;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_leads'     => Lead::count(),
            'new_leads'       => Lead::where('status', 'new')->count(),
            'total_employees' => Employee::where('status', 'active')->count(),
            'today_present'   => Attendance::where('date', today()->toDateString())
                ->where('status', 'present')->count(),
        ];
        $recent_leads = Lead::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recent_leads'));
    }
}
