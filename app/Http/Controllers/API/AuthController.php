<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string",
            'email' => 'email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
        ]);

        return response()->success(compact('user'));
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)
        ->where('password', bcrypt($request->password))
        ->findOrFail();

        return response()->success(compact('user'));
    }
}
