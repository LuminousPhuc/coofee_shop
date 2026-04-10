<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }

    public function updateUser(User $user, array $data)
    {
        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        return $user->update($payload);
    }

    public function deleteUser(User $user)
    {
        // Bonus: Prevent admin from deleting themselves
        if (auth()->id() === $user->id) {
            throw new \Exception('You cannot delete yourself.');
        }

        return $user->delete();
    }
}
