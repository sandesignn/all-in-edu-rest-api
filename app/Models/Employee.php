<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'id', 'nip', 'name', 'nik', 'no_kk', 'birth', 'roles',
        'address', 'city', 'phone_number', 'status', 'gender',
        'religion', 'salary', 'marital_status',
    ];
}
