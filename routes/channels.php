<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notifications', function ($user) {
    Log::info("user => " . json_encode($user));
    // Log::info("ID => " . json_encode($id));
    return $user != null;
});
Broadcast::channel('chat.{id}', function ($user, $id) {
    Log::info("chat.{user} => " . json_encode($user));
    Log::info("chat.{id} => " . json_encode($id));
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notif.{id}', function ($user, $id) {
    Log::info("notif.{user} => " . json_encode($user));
    Log::info("notif.{id} => " . json_encode($id));
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function ($user) {
    Log::info("PRESENCT chat user => " . json_encode($user));
    if ($user) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
