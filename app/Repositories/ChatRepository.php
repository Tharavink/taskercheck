<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Pusher\Pusher;

use App\Models\Conversation;
use App\Models\Chat;
use App\Models\ChatRecipient;
use App\Models\ConversationUser;
use App\Models\User;
use App\Models\File;

use App\Events\SendChat;

class ChatRepository extends BaseRepository
{
    protected $model;

    public function __construct(Chat $model) {
        $this->model = $model;
    }

    public function client($data)
    {
        foreach ($data['events'] as $key => $evt) {
            if ($evt['event'] == 'client-chat-sent') {
                $data = json_decode($evt['data'], true);
                $chats = $data['chats'];
                foreach ($chats as $key => $cht) {
                    if (isset($cht['library']) && !empty($cht['library'])) {
                        $img_file = File::create($cht['library']);

                        $chat = [
                            'conversation_id' => $data['conversation_id'],
                            'user_id' => $cht['user']['_id'],
                            'message' => $cht['text'],
                            'created_at' => Carbon::parse($cht['createdAt']),
                            'img_id' => $img_file->id
                        ];
                    } else {
                        $chat = [
                            'conversation_id' => $data['conversation_id'],
                            'user_id' => $cht['user']['_id'],
                            'message' => $cht['text'],
                            'created_at' => Carbon::parse($cht['createdAt'])
                        ];
                    }
    
                    $chat = new Chat($chat);
                    $chat->save();
                }

                $conversation = Conversation::find($data['conversation_id']);
                if (!is_null($conversation)) {
                    event(new SendChat($conversation));
                }
        
                return response()->json(["message" => "Successfully saved"], 201);
            }
        }
    }

    public function channel($data)
    {
        // not using for now
    }

    public function presence($data)
    {
        // not using for now
    }
}