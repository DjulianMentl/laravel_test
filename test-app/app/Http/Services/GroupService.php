<?php

namespace App\Http\Services;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupService
{
    public function storeFromRequest(Request $request): Group
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expire_hours' => 'required|integer',
        ]);

        return Group::create($validated);
    }

    public function updateFromRequest(Request $request, Group $group): Group
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'expire_hours' => 'integer',
        ]);

        $group->update($validated);

        return $group;
    }

    /**
     * @throws \Exception
     */
    public function addUserToGroup(string $userId, string $groupId): void
    {
        $user = User::findOrFail($userId);
        $group = Group::findOrFail($groupId);

        if (!$user->active) {
            $user->active = true;
            $user->save();
        }

        GroupUser::create([
            'user_id' => $user->id,
            'group_id' => $group->id,
        ]);
    }
}
