<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::where('status', 'active')->get();
        $date = request('date', today()->toDateString());
        $attendances = Attendance::with('employee')
                        ->where('date', $date)->get();
        return view('admin.attendance.index', compact('employees', 'attendances', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date'        => 'required|date',
            'status'      => 'required|in:present,absent,half_day,leave',
            'check_in'    => 'nullable',
            'check_out'   => 'nullable',
            'hours_worked'=> 'nullable|numeric',
        ]);

        Attendance::updateOrCreate(
            ['employee_id' => $request->employee_id, 'date' => $request->date],
            $request->only(['status', 'check_in', 'check_out', 'hours_worked'])
        );

        return back()->with('success', 'Attendance saved!');
    }
}