<?php

namespace App\Console\Commands;

use App\Http\Services\GroupService;
use Exception;
use Illuminate\Console\Command;

class AddUserToGroupCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:member';

    /**
     * @var string
     */
    protected $description = 'Добавление пользователя в группу';


    public function handle(): void
    {
        $userId = $this->ask('Введите ID пользователя');
        $groupId = $this->ask('Введите ID группы');

        try {
            $this->laravel->make(GroupService::class)->addUserToGroup($userId, $groupId);

            $this->info('Пользователь добавлен в группу');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
