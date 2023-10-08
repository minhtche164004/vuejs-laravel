<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credential)) {
            return response()->json([
                'status' => true,
                'message' => 'Success'
            ]);
        }
        return "<h2>Username or password invalid!</h2>";
        return view('login');
    }
}
