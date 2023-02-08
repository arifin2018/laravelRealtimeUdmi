<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use App\Events\UserSessionChanged;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastUserLoginNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        Log::debug("event handle broadcastUser => " . json_encode($event));
        Log::debug("event handle broadcastUser USER => " . json_encode($event->user->id));
        Broadcast(new UserSessionChanged("{$event->user->name} is online", "success"));
    }
}
