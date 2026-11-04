<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Employee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('employee')->latest()->get();
        $employees = Employee::where('status', 'active')->get();

        // employee_id => monthly salary
        $salaryMap = Employee::pluck('salary', 'id')
            ->map(fn($s) => (float) $s)
            ->toArray();

        // employee_id => [{month, type, amount}] for committed (non-voided)
        // salary/advance payouts — used to live-compute the net payable.
        $committedMap = Payment::where('status', 'paid')
            ->whereIn('type', ['salary', 'advance'])
            ->get(['employee_id', 'month', 'type', 'amount'])
            ->groupBy('employee_id')
            ->map->map(fn($p) => [
                'month'  => $p->month,
                'type'   => $p->type,
                'amount' => (float) $p->amount,
            ])
            ->toArray();

        return view('admin.payments.index', compact(
            'payments',
            'employees',
            'salaryMap',
            'committedMap'
        ));
    }

    /**
     * Money against a worker's monthly salary budget. Advances are deducted
     * from salary, so salary + advance payouts for one employee/month may
     * never exceed the employee's monthly salary. Bonuses/other are extra.
     */
    private function balanceFor(int $employeeId, string $month): array
    {
        $salary = (float) (Employee::whereKey($employeeId)->value('salary') ?? 0);

        $rows = Payment::where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('status', 'paid')
            ->whereIn('type', ['salary', 'advance'])
            ->get(['type', 'amount']);

        $advances   = (float) $rows->where('type', 'advance')->sum('amount');
        $paidSalary = (float) $rows->where('type', 'salary')->sum('amount');

        return [
            'salary'     => $salary,
            'advances'   => $advances,
            'paidSalary' => $paidSalary,
            'remaining'  => $salary - $advances - $paidSalary,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'  => 'required|exists:employees,id',
            'amount'       => 'required|numeric|min:0.01',
            'type'         => 'required|string',
            'payment_date' => 'required|date',
            'month'        => 'required|string',
            'notes'        => 'nullable|string',
        ]);

        // Guard against overpaying the monthly salary budget.
        if (in_array($request->type, ['salary', 'advance'], true)) {
            $b = $this->balanceFor((int) $request->employee_id, $request->month);

            if ($b['salary'] > 0 && $request->amount > $b['remaining']) {
                $money = fn($n) => '$' . number_format($n, 2);

                $context = "Salary is {$money($b['salary'])}";
                if ($b['advances'] > 0) {
                    $context .= " but {$money($b['advances'])} was already given as advance";
                }
                if ($b['paidSalary'] > 0) {
                    $context .= " and {$money($b['paidSalary'])} already paid as salary";
                }
                $context .= ". Net payable for {$request->month} is {$money($b['remaining'])}"
                    . " — you can't record {$money($request->amount)} (it would overpay by"
                    . ' ' . $money(max(0, $request->amount - $b['remaining'])) . ').';

                return redirect()->back()
                    ->withInput()
                    ->withErrors(['amount' => $context]);
            }
        }

        Payment::create($request->all() + ['status' => 'paid']);
        return back()->with('success', 'Payment recorded!');
    }

    /**
     * Money records are never hard-deleted — they are voided (auditable,
     * reversible) and excluded from totals.
     */
    public function void(Payment $payment)
    {
        $payment->update(['status' => 'voided']);
        return back()->with('success', 'Payment voided. The record stays for audit and can be restored.');
    }

    public function restore(Payment $payment)
    {
        $payment->update(['status' => 'paid']);
        return back()->with('success', 'Payment restored.');
    }
}
