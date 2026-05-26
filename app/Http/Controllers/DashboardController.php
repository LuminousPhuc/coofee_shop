<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $orders = Order::with('items.product')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(10)
                    ->get();

        $addresses = $user->addresses()->orderBy('is_default', 'desc')->latest()->get();

        return view('dashboard', compact('user', 'orders', 'addresses'));
    }
}
