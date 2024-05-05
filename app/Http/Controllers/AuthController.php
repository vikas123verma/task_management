<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utilities\APIResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request, APIResponse $apiResponse)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            $apiResponse->data = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ];
        } else {
            $apiResponse->statusCode = Response::HTTP_UNAUTHORIZED;
            $apiResponse->message = [
                'error' => 'Unauthorized'
            ];
        }
        return $apiResponse->getResponse();
    }

    public function register(Request $request, APIResponse $apiResponse)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'email_verified_at' => Carbon::now()
        ]);

        $token = $user->createToken('AuthToken')->plainTextToken;

        $apiResponse->statusCode = Response::HTTP_CREATED;
        $apiResponse->message = ['success' => 'User created successfully'];
        $apiResponse->data = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ];
        return $apiResponse->getResponse();
    }
}
