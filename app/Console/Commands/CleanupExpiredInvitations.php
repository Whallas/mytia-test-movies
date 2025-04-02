<?php
namespace App\Console\Commands;

use App\Models\Invitation;
use Illuminate\Console\Command;

class CleanupExpiredInvitations extends Command
{
    protected $signature = 'invitations:cleanup';
    protected $description = 'Remove expired invitations from the database';

    public function handle()
    {
        $expiredInvitations = Invitation::where('expires_at', '<', now())->delete();
        $this->info("Deleted {$expiredInvitations} expired invitations.");
    }
}
