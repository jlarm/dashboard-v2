<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            if (! Auth::attempt($request->all())) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $user = User::query()->where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
