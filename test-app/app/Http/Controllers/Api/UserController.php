<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function store(Request $request): UserResource
    {
        $user = $this->userService->storeFromRequest($request);

        return new UserResource($user);
    }

    public function show(string $id): UserResource
    {
        $user = User::with('groups')->findOrFail($id);

        return new UserResource($user);
    }

    public function update(Request $request, User $user): UserResource
    {
        $user = $this->userService->updateFromRequest($request, $user);

        return new UserResource($user);
    }
}
