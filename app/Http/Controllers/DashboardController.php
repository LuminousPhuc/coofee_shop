<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'phone.max' => 'Số điện thoại không được quá 15 ký tự.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user->name = $data['name'];
        $user->phone = $data['phone'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }
}
