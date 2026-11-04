<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Seed salary payments (USD) for the last two months, plus a bonus and an advance.
     * Idempotent: matching on employee + month + type.
     */
    public function run(): void
    {
        $employees = Employee::where('status', 'active')->get();
        $months = [
            Carbon::today()->subMonth()->format('F Y'),
            Carbon::today()->format('F Y'),
        ];

        foreach ($employees as $i => $employee) {
            foreach ($months as $month) {
                Payment::updateOrCreate(
                    ['employee_id' => $employee->id, 'month' => $month, 'type' => 'salary'],
                    [
                        'amount' => $employee->salary,
                        'payment_date' => Carbon::createFromFormat('F Y', $month)->startOfMonth()->addDays(min(27, $i * 2))->toDateString(),
                        'notes' => 'Monthly salary',
                    ]
                );
            }
        }

        // A team bonus and an advance to show the other payment types.
        $lead = $employees->firstWhere('role', 'Team Lead') ?? $employees->first();
        $current = $months[1];

        if ($lead) {
            Payment::updateOrCreate(
                ['employee_id' => $lead->id, 'month' => $current, 'type' => 'bonus'],
                ['amount' => 500, 'payment_date' => Carbon::today()->subDays(3)->toDateString(), 'notes' => 'Quarterly performance bonus']
            );
            Payment::updateOrCreate(
                ['employee_id' => $employees->last()->id, 'month' => $current, 'type' => 'advance'],
                ['amount' => 300, 'payment_date' => Carbon::today()->subDays(6)->toDateString(), 'notes' => 'Salary advance']
            );
        }
    }
}
