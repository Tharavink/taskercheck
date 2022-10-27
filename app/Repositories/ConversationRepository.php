<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Pusher\Pusher;

use App\Models\Conversation;
use App\Models\Chat;
use App\Models\ChatRecipient;
use App\Models\ConversationUser;
use App\Models\User;
use App\Models\ServiceRequest;

use App\Events\SendChat;

class ConversationRepository extends BaseRepository
{
    protected $model;

    public function __construct(Conversation $model) {
        $this->model = $model;
    }

    public function index($request)
    {
        $conversation_ids = $request->user()->conversations->pluck('id')->toArray();
        return $this->model->join('chats', 'conversations.id', '=', 'chats.conversation_id')
                            ->select('conversations.*', DB::raw('MAX(chats.id) AS latest_chat_id'))
                            ->with('service_request.service', 'service_request.business', 'service_request.requester')
                            ->groupBy('conversations.id')
                            ->orderBy('latest_chat_id', 'DESC')->with('latest')
                            ->whereIn('conversations.id', $conversation_ids)->get();
    }

    public function store($request)
    {
        $service_request = ServiceRequest::with('business', 'requester')->find($request->service_request_id);

        $conversation = $this->model->create($request->all());

        ConversationUser::create(['conversation_id' => $conversation->id, 'user_id' => $service_request->business->user_id]);
        ConversationUser::create(['conversation_id' => $conversation->id, 'user_id' => $service_request->user_id]);

        Chat::create([
            'conversation_id' => $conversation->id,
            'is_bot' => 1,
            'message' => 'Beginning of conversation for service request by '.$service_request->business->name.' to '.$service_request->requester->name
        ]);

        event(new SendChat($conversation));

        return $conversation;
    }

    public function show($id)
    {
        return $this->model->with('chats.user.profile_pic', 'service_request.service', 'service_request.business', 'service_request.requester', 'users')->find($id);
    }
}