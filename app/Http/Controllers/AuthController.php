<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'message' => 'User created successfully'
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Email немесе құпия сөз қате',
                'status_code' => 401
            ], 401);
        }

        $user = $request->user();
        $tokenData = $user->createToken('Token Name');
        $token = $tokenData->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(2);
        } else {
            $token->expires_at = Carbon::now()->addDays(3);
        }

        if ($token->save()) {
            return response()->json([
                'user' => $user,
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Серверде қателіктер, кейінірек қайталап көріңіз',
                'status_code' => 500
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout Successful',
            'status_code' => 200
        ], 200);
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json($request->user(), 200);
        }

        return response()->json([
            'message' => 'Not logged in',
            'status_code' => 500
        ], 500);
    }
}
