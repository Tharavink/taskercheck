<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return $this->repository->index($request);
    }

    public function update(Request $request, $id)
    {
        return $this->repository->update($request, $id);
    }
}
