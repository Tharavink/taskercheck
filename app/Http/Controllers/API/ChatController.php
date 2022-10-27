<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\ChatRepository;

class ChatController extends Controller
{
    protected $repository;

    public function __construct(ChatRepository $repository)
    {
        $this->repository = $repository;
    }

    public function client(Request $request)
    {
        return $this->repository->client($request->all());
    }

    public function channel(Request $request)
    {
        return $this->repository->channel($request->all());
    }

    public function presence(Request $request)
    {
        return $this->repository->presence($request->all());
    }
}
