<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return
            view('admin.auth-login');
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Only allow if the name is exactly 'adminuser'
            if ($user->name === 'adminuser') {
                $request->session()->regenerate();
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_email', $user->email);
                $request->session()->put('user_name', $user->name);

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',

                ]);
            }

            Auth::logout();
            $error = 'Access denied. Only adminuser can login.';

            return response()->json([
                'status' => false,
                'message' => $error
            ], 403);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }
}
