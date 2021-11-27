<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;
use App\Models\Leave;
use Exception;

class LeaveController extends Controller
{
    public function applyLeave(Request $request)
    {
        try {
            $rules = [
                'leave_date' => 'string|required',
                'reason_leave' => 'string|required',
                'description_status' => 'string',
                'status' => 'in:PENDING,APPROVED,DECLINED',
            ];

            $data = $request->all();
            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                return ResponseFormatter::error([
                    'message' => 'validation failed',
                    'error' => $validation->errors(),
                ], 'failed to apply leave');
            }

            $userLeave = Leave::where('status', 'PENDING')->where('employee_id', $request->employee_id)->first();
            if ($userLeave) {
                return ResponseFormatter::error([
                    'message' => 'you have applied for leave this time',
                ], 'failed to apply leave');
            }
            $leave = Leave::create([
                'employee_id' => $request->employee_id,
                'leave_date' => $request->leave_date,
                'leave' => $request->leave,
                'reason_leave' => $request->reason_leave,
                'description_status' => $request->description_status,
            ]);

            return ResponseFormatter::success([
                'message' => 'validation failed',
                'data' => $leave,
            ], 'failed to apply leave');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Failed to apply leave', 500);
        }
    }

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        if ($id) {
            $leaves = Leave::find($id);

            if ($leaves)
                return ResponseFormatter::success(
                    $leaves,
                    'get leave data success'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'data not found',
                    404
                );
        }
        $leaves = Leave::query();

        return ResponseFormatter::success(
            $leaves->paginate($limit),
            'Data list kategori produk berhasil diambil'
        );
    }
}
