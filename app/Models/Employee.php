<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'phone', 'role', 'nationality', 'join_date', 'salary', 'status'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
