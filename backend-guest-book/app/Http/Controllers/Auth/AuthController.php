<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('API token')->plainTextToken;


        return response()->json([
            'success' => true,
            'message' => 'Sukses Registrasi',
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]
        ], 201); // 201 Created status code
    }
    public function login(Request $request)
    {
        $request->validate([
            /**
             * Email
             * @example admin@gmail.com
             */
            'email' => 'required|email',
            /**
             * Email
             * @example 12345678
             */
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah',
                'data' => null
            ], 422);
        }
        $token = $user->createToken('API token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'Sukses Login',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }
}
