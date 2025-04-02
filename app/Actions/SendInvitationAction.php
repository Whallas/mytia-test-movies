<?php

namespace App\Actions;

use App\Models\Invitation;
use App\Notifications\InvitationNotification;
use Illuminate\Support\Facades\Notification;

class SendInvitationAction
{
    public function execute(string $email, int $role): void
    {
        $invitation = Invitation::create([
            'email' => $email,
            'role' => $role,
        ]);

        Notification::route('mail', $email)
            ->notify(new InvitationNotification($invitation));
    }
}
