<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:10',
        ]);
        Service::create($request->all());
        return redirect()->route('admin.services.index')
               ->with('success', 'Service added!');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($request->all());
        return redirect()->route('admin.services.index')
               ->with('success', 'Service updated!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
               ->with('success', 'Service deleted.');
    }
}