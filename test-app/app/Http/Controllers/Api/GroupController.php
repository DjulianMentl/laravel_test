<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Services\GroupService;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        private readonly GroupService $groupService,
    ) {
    }

    public function store(Request $request): GroupResource
    {
        $group = $this->groupService->storeFromRequest($request);

        return new GroupResource($group);
    }

    public function show(string $id): GroupResource
    {
        $group = Group::with('users')->findOrFail($id);

        return new GroupResource($group);
    }

    public function update(Request $request, Group $group): GroupResource
    {
        $group = $this->groupService->updateFromRequest($request, $group);

        return new GroupResource($group);
    }

    /**
     * @throws \Exception
     */
    public function addUserToGroup(string $userId, string $groupId): void
    {
        $this->groupService->addUserToGroup($userId, $groupId);
    }
}
