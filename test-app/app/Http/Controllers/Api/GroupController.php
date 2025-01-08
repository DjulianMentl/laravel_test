<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request): GroupResource
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expire_hours' => 'required|integer',
        ]);

        $group = Group::create($validated);

        return new GroupResource($group);
    }

    public function show(string $id): GroupResource
    {
        $group = Group::with('users')->findOrFail($id);
        return new GroupResource($group);
    }

    public function update(Request $request, Group $group): GroupResource
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'expire_hours' => 'integer',
        ]);

        $group->update($validated);

        return new GroupResource($group);
    }
    public function addUserToGroup(string $userId, string $groupId): void
    {
        $user = User::findOrFail($userId);
        $group = Group::findOrFail($groupId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        if (!$group) {
            throw new \Exception('Group not found');
        }

        GroupUser::create([
            'user_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }
}
