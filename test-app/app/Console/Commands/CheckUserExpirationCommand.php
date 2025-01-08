<?php

namespace App\Console\Commands;

use App\Mail\GroupExpirationNotification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

                    // TODO: переделать через очередь, чтоб команда не падали при ошибке отправки email
                    Mail::to($user->email)->send(new GroupExpirationNotification($user->name, $group->name));
                }
            });
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Проверка завершена');
    }
}
