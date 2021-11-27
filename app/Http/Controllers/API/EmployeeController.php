<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Exception;


class EmployeeController extends Controller
{
    public function getAll()
    {
        $employees = Employee::all();
        return ResponseFormatter::success($employees, 'Berhasil mendapatkan data');
    }

    public function getEmployee($id)
    {
        $employee = Employee::leftJoin('users', 'employees.id', '=', 'users.employee_id')->where('employees.id', $id)->first();
        if (!$employee) {
            return ResponseFormatter::error('employee not found', 404);
        }
        return ResponseFormatter::success($employee, 'Berhasil mendapatkan data');
    }

    public function addEmployee(Request $request)
    {
        try {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'nik' => ['required', 'string', 'max:16'],
                'no_kk' => ['required', 'string', 'max:16'],
                'birth' => ['required', 'date'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:86'],
                'phone_number' => ['required', 'string', 'max:14'],
                'status' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'religion' => ['required', 'string', 'max:48'],
                'salary' => ['required', 'integer'],
                'marital_status' => ['required', 'string']
            ];

            $data = $request->all();
            $validation = Validator::make($data, $rules);

            if ($validation->fails()) {
                return ResponseFormatter::error([
                    'message' => 'validation failed',
                    'error' => $validation->errors(),
                ], 'failed to add employee');
            }

            $cekEmployee = Employee::where('nik', $request->nik)->first();
            if ($cekEmployee) {
                return ResponseFormatter::error('employee already registered', 'fail to add employee', 400);
            }

            $employees = Employee::create($data);

            return ResponseFormatter::success([
                'employee' => $employees
            ], 'Employee registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Failed to add employee', 500);
        }
    }

    public function updateEmployee(Request $request, $id)
    {
        try {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'nik' => ['required', 'string', 'max:16'],
                'no_kk' => ['required', 'string', 'max:16'],
                'birth' => ['required', 'date'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:86'],
                'phone_number' => ['required', 'string', 'max:14'],
                'status' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'religion' => ['required', 'string', 'max:48'],
                'salary' => ['required', 'integer'],
                'marital_status' => ['required', 'string']
            ];

            $data = $request->all();
            $validation = Validator::make($data, $rules);

            if ($validation->fails()) {
                return ResponseFormatter::error([
                    'message' => 'validation failed',
                    'error' => $validation->errors(),
                ], 'failed to add employee');
            }

            $data = $request->all();
            $employee = Employee::find($id);
            if (!$employee) {
                return ResponseFormatter::error('employee not found', 404);
            }
            $employee->fill($data);
            $employee->save();

            return ResponseFormatter::success([
                'name' => $employee->name,
            ], 'data updated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Failed to update employee', 500);
        }
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return ResponseFormatter::error('employee not found', 404);
        }
        $employee->delete();

        return ResponseFormatter::success([
            'name' => $employee->name,
        ], 'data deleted');
    }
}
