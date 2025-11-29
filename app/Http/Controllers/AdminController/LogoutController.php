<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(){
        Session::forget('user_id');
        Session::forget('email'); 

        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('email')); 

        return redirect('/admin/login')->with('success', 'Logged out successfully');
    }
}
