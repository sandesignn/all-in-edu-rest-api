<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {

            $credential = request(['email', 'password']);
            if (!Auth::attempt($credential)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'authentication failed', 500);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                return throw new Exception("invalid credential");
            }

            $resultToken = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $resultToken,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Unauthenticated', 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $userCek = User::where('email', $request->email)->first();
            if ($userCek) {
                return ResponseFormatter::error('employee already registered', 'fail to add employee', 400);
            }
            User::create([
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'password' => Hash::make($request->password)
            ]);

            $user = User::where('email', $request->email)->first();
            $resultToken = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $resultToken,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'failed register user', 500);
        }
    }
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'token revoked');
    }
}
