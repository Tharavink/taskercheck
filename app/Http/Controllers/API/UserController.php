<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function register(Request $request)
    {
        return $this->repository->register($request);
    }

    public function login(Request $request)
    {
        return $this->repository->login($request);
    }

    public function update(Request $request, $id)
    {
        return $this->repository->update($request, $id);
    }

    public function getData(Request $request)
    {
        return $this->repository->getData($request);
    }

    public function resendVerification(Request $request)
    {
        return $this->repository->resendVerification($request);
    }

    public function logout(Request $request)
    {
        return $this->repository->logout($request);
    }

    public function getPin(Request $request)
    {
        return $this->repository->getPin($request);
    }

    public function resetPassword(Request $request)
    {
        return $this->repository->resetPassword($request);
    }

    public function getCards(Request $request)
    {
        return $this->repository->getCards($request);
    }
}
