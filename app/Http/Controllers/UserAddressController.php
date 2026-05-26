<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_name'  => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:15',
            'address_line'    => 'required|string|max:500',
            'is_default'      => 'nullable|boolean',
        ]);

        $user = auth()->user();
        $isDefault = $request->has('is_default') ? (bool) $request->input('is_default') : false;

        // If this is the user's first address, make it default automatically
        if ($user->addresses()->count() === 0) {
            $isDefault = true;
        }

        if ($isDefault) {
            // Set all other user addresses to not default
            $user->addresses()->update(['is_default' => 0]);
        }

        $user->addresses()->create([
            'recipient_name'  => $data['recipient_name'],
            'recipient_phone' => $data['recipient_phone'],
            'address_line'    => $data['address_line'],
            'is_default'      => $isDefault,
        ]);

        return redirect()->route('dashboard', ['tab' => 'addresses'])->with('success', 'Thêm địa chỉ thành công!');
    }

    public function update(Request $request, UserAddress $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'recipient_name'  => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:15',
            'address_line'    => 'required|string|max:500',
            'is_default'      => 'nullable|boolean',
        ]);

        $isDefault = $request->has('is_default') ? (bool) $request->input('is_default') : false;

        if ($isDefault) {
            // Set all other user addresses to not default
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => 0]);
        }

        $address->update([
            'recipient_name'  => $data['recipient_name'],
            'recipient_phone' => $data['recipient_phone'],
            'address_line'    => $data['address_line'],
            'is_default'      => $isDefault,
        ]);

        return redirect()->route('dashboard', ['tab' => 'addresses'])->with('success', 'Cập nhật địa chỉ thành công!');
    }

    public function destroy(UserAddress $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted address was default, set another address as default if exists
        if ($wasDefault) {
            $nextAddress = auth()->user()->addresses()->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => 1]);
            }
        }

        return redirect()->route('dashboard', ['tab' => 'addresses'])->with('success', 'Xóa địa chỉ thành công!');
    }

    public function setDefault(UserAddress $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        auth()->user()->addresses()->update(['is_default' => 0]);
        $address->update(['is_default' => 1]);

        return redirect()->route('dashboard', ['tab' => 'addresses'])->with('success', 'Đã đặt làm địa chỉ mặc định!');
    }
}
