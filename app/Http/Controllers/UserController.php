<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|string',
            'password' =>'required|string|min:6'
        ]);

        $user = User::create([
            'username' => $validator['username'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => "$user->username berhasil register",
            'token' => $token,
        ]);

    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);
        
        $user = User::where('email', $validator['email'])->firstOrFail();
        if(!$user || !Hash::check($validator['password'], $user->password)){
            return response()->json([
                'status' => 401,
                'message' => "$user->username gagal login, mohon cek kembali data",
            ], 401);
        } else {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'message' => "$user->username berhasil login",
                'token' => $token,
            ], 200);
        }

    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'berhasil logout',
        ], 200);
    }

}
