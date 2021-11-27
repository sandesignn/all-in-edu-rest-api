<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id', 'leave_date', 'reason_leave', 'status', 'status_description'
    ];

    public function users()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
