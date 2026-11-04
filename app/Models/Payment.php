<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'employee_id',
        'amount',
        'type',
        'payment_date',
        'month',
        'notes',
        'status'
    ];

    public function isVoided(): bool
    {
        return $this->status === 'voided';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
