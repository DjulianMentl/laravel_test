<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class CheckUserExpirationCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:check_expiration';

    /**
     * @var string
     */
    protected $description = 'Исключить пользователей из групп с истекшим сроком';

    public function handle(): void
    {
        $now = Carbon::now();

        try {
            User::whereHas('groups', function ($query) use ($now) {
                $query->where('expired_at', '<', $now);
            })->each(function ($user) use ($now) {
                $expiredGroups = $user->groups()->where('expired_at', '<', $now)->get();
                foreach ($expiredGroups as $group) {
                    $user->groups()->detach($group->id);
                    $this->info("Пользователь ID: {$user->id} исключен из группы ID: {$group->id}");
                }
            });
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Проверка завершена');
    }
}
