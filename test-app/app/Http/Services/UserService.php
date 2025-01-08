<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public function storeFromRequest(Request $request): User
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'active' => 'boolean',
        ]);

        return User::create($validated);
    }

    public function updateFromRequest(Request $request, User $user): User
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'active' => 'boolean',
        ]);

        $user->update($validated);

        return $user;
    }
}
