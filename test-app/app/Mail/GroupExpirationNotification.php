<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GroupExpirationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected readonly string $userName,
        protected readonly string $groupName,
    ) {
    }

    public function build(): GroupExpirationNotification
    {
        return $this->view('emails.group_expiration')
            ->subject('Срок участия в группе истек')
            ->with([
                'userName' => $this->userName,
                'groupName' => $this->groupName,
            ]);
    }
}
