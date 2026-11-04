<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'phone'     => 'required|string|max:20',
            'role'      => 'required|string|max:50',
            'join_date' => 'required|date',
            'salary'    => 'nullable|numeric',
        ]);
        Employee::create($request->all());
        return redirect()->route('admin.employees.index')
               ->with('success', 'Employee added successfully!');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($request->all());
        return redirect()->route('admin.employees.index')
               ->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')
               ->with('success', 'Employee removed.');
    }
}