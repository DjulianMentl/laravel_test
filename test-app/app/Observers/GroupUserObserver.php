<?php

namespace App\Observers;

use App\Models\GroupUser;
use Carbon\Carbon;
class GroupUserObserver
{
    public function creating(GroupUser $groupUser): void
    {
        $group = $groupUser->group;

        if ($group && $group->expire_hours) {
            $groupUser->expired_at = Carbon::now()->addHours($group->expire_hours);
        }
    }
}
