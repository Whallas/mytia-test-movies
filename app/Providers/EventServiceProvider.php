<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\User;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Events and listeners
    ];

    public function boot()
    {
        parent::boot();
    }
}
