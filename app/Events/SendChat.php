<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Chat;
use App\Models\User;

class SendChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    protected $conversation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        array_push($channels, new PrivateChannel('conversation.'.$this->conversation->id));

        $users = ConversationUser::where('conversation_id', $this->conversation->id)->pluck('user_id')->toArray();
        foreach ($users as $key => $id) {
            array_push($channels, new PrivateChannel('chat.'.$id));
        }

        return $channels;
    }

    public function broadcastAs()
    {
        return 'chat-sent';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $conversation = Conversation::with('latest')->find($this->conversation->id);

        return [
            'conversation' => $conversation
        ];
    }
}
