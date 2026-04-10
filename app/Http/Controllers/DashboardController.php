<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $message = $user->role === 'admin' ? 'Welcome Admin' : 'Welcome User';
        
        return view('dashboard', compact('message'));
    }
}
