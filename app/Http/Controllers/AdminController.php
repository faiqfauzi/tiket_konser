<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate([
            'username' => 'required|string|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6'
        ]);

        $admin = Admin::create([
            'username' => $validator['username'],
            'email' => $validator['email'],
            'password' => Hash::make($validator['password'])
        ]);

        $token = $admin->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 200,
            'message' => "$admin->username berhasil register",
            'token' => $token,
        ], 200);

    }

    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        $admin = Admin::where('email', $validator['email'])->firstOrFail();
        if(!$admin || !Hash::check($validator['password'], $admin->password)){
            return response()->json([
                'status' => 401,
                'message' => "$admin->username gagal login, mohon cek kembali data",
            ], 401);
        } else {
            $token = $admin->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => 200,
                'message' => "$admin->username berhasil login",
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
