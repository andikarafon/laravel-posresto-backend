<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //untuk Login api
    public function login(Request $request)
    {
        //validate the request
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        //check if the user exists
        $user   = User::where('email', $request->email)->first();
        if (!$user)
        {
            return response()->json([
                'status'        => 'error',
                'message'       => 'User Not Found'
            ], 404);
        }

        //check if the password is correct
        if (!Hash::check ($request->password, $user->password))
        {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Invalid credentials'
            ], 401);
        }

        //generate token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status'        => 'success',
            'token'         => $token,
            'user'          => $user
        ], 200);
    }

}
