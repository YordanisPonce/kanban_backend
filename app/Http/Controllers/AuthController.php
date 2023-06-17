<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthTrait;
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login']]);
    }



    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], $this->unauthorized);
            }

            $user = User::whereEmail($request->email)->firstOrFail();
            $kanban_token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $kanban_token
            ], $this->successCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Su session ha finalizado exitosamente'
            ], $this->successCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }
}
