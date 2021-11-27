<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'nip', 'name', 'nik', 'no_kk', 'birth', 'roles',
        'address', 'city', 'phone_number', 'status', 'gender',
        'religion', 'salary', 'marital_status',
    ];
}
