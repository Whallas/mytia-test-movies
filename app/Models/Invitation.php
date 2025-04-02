<?php
namespace App\Models;

use App\Observers\InvitationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[ObservedBy([InvitationObserver::class])]
class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'role',
        'expires_at',
    ];

    public function isExpired(): bool
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
