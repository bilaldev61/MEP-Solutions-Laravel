<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::latest()->paginate(15);
        return view('admin.leads.index', compact('leads'));
    }

    public function update(Request $request, Lead $lead)
    {
        $lead->update(['status' => $request->status]);
        return back()->with('success', 'Lead status updated!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back()->with('success', 'Lead deleted.');
    }
}
