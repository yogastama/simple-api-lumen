<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email',
            'password' => 'required:min:5'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        return response()->json([
            'message' => 'Successful registration',
            'data' => $user,
            'code' => 201
        ], 201);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);
        $data = $request->all();
        // check isset user
        $user = User::where('email', $data['email'])->first();
        // if there is no user
        if (!$user) {
            return response()->json([
                'message' => 'Failed to login',
                'code' => 401
            ], 401);
        }
        // check password
        $isValidPassword = Hash::check($data['password'], $user->password);
        // if not same password
        if (!$isValidPassword) {
            return response()->json([
                'message' => 'Failed to login',
                'code' => 401
            ], 401);
        }
        // if loggedin generate token
        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);
        return response()->json([
            'message' => 'Success login',
            'data' => $user
        ]);
    }
}
