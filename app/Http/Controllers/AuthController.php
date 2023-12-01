<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::query()->create($validatedData);

        return response()->json(['user' => $user, 'message' => 'User registered successfully']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->string('email'), 'password' => $request->string('password')])) {

            /* @var User $user */
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['user' => $user, 'access_token' => $token]);

        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
