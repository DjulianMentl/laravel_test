<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): UserResource
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'active' => 'boolean',
        ]);

        $user = User::create($validated);

        return new UserResource($user);
    }

    public function show(string $id): UserResource
    {
        $user = User::with('groups')->findOrFail($id);
        return new UserResource($user);
    }

    public function update(Request $request, User $user): UserResource
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $user->id,
            'active' => 'boolean',
        ]);

        $user->update($validated);

        return new UserResource($user);
    }
}
