<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'regex:/^[A-Za-zА-Яа-яЁё]+$/u'],
            'last_name' => ['required', 'regex:/^[A-Za-zА-Яа-яЁё]+$/u'],
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20', // добавлено
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'], // добавлено
            'password' => bcrypt($validated['password']),
            'role' => 'client',
        ]);

        $token = $user->createToken('auth_token', [$user->role])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'role' => $user->role,
        ]);
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token', [$user->role])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'role' => $user->role,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}

