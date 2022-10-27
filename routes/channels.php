<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\ConversationUser;
use App\Models\ServiceRequest;
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

Broadcast::channel('chat.{userId}', function ($person, $userId) {
    if ($person->id == $userId) {
        return array('member' => true, 'id' => $person->id, 'name' => $person->name);
    }
});

Broadcast::channel('conversation.{conversation_id}', function ($person, $conversation_id) {
    $permission = ConversationUser::where('conversation_id', $conversation_id)->where('user_id', $person->id)->first();

    if (! $permission) {
        return false;
    } else {
        return array(true, 'name' => $person->name);
    }
});

Broadcast::channel('request.{service_id}', function ($person, $service_id) {
    $request = ServiceRequest::find($service_id);
    if ($request->user_id == $person->id || $request->business->user_id) {
        return array(true, 'name' => $person->name);
    } else {
        return false;
    }
});