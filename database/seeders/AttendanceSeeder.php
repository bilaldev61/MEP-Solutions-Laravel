<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Seed attendance for the last working week so the panel has history.
     * Idempotent: matching on employee + date.
     */
    public function run(): void
    {
        $employees = Employee::all(['id', 'name']);

        // Mostly present, with a few half days / a leave / an absence sprinkled in.
        $pattern = ['present', 'present', 'half_day', 'present', 'present', 'leave', 'absent'];

        foreach ($employees as $i => $employee) {
            for ($day = 6; $day >= 0; $day--) {
                $date = Carbon::today()->subDays($day)->toDateString();
                $status = $pattern[($i + $day) % count($pattern)];

                Attendance::updateOrCreate(
                    ['employee_id' => $employee->id, 'date' => $date],
                    [
                        'status' => $status,
                        'check_in' => in_array($status, ['present', 'half_day']) ? '08:00:00' : null,
                        'check_out' => $status === 'present' ? '17:00:00' : ($status === 'half_day' ? '12:30:00' : null),
                        'hours_worked' => $status === 'present' ? 9.00 : ($status === 'half_day' ? 4.50 : null),
                    ]
                );
            }
        }
    }
}
