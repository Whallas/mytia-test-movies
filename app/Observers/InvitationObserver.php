<?php
namespace App\Observers;

use App\Models\Invitation;

class InvitationObserver
{
    public function creating(Invitation $invitation)
    {
        $invitation->expires_at = now()->addHours(48);
    }
}
