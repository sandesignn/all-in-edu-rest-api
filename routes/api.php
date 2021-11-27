<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\LeaveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;


Route::post('users/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('users', [UserController::class, 'register']);
    Route::post('employees', [EmployeeController::class, 'addEmployee']);
    Route::get('employees', [EmployeeController::class, 'getAll']);
    Route::get('employees/{id}', [EmployeeController::class, 'getEmployee']);
    Route::put('employees/{id}', [EmployeeController::class, 'updateEmployee']);
    Route::delete('employees/{id}', [EmployeeController::class, 'deleteEmployee']);

    Route::post('leave', [LeaveController::class, 'applyLeave']);
    Route::get('leave', [LeaveController::class, 'all']);

    Route::post('users', [UserController::class, 'updateProfile']);
    Route::post('users/logout', [UserController::class, 'logout']);
});
