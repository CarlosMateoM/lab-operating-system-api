<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'status' => 'session successfully started',
                'message' => 'token successfully generated',
                'token' => $token,
            ]);
        } else {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'status' => 'user successfully registered',
            'message' => 'login to generate an access token',
        ], 200);
    }

    public function expireToken(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'token expired successfully',
            'message' => 'token expired'
        ], 200);
    }

    public function expireAllTokens(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'tokens expired successfully',
            'message' => 'no tokens available to the user'
        ], 200);
    }
}
