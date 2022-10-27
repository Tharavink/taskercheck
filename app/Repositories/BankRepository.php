<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;

use App\Models\Bank;

class BankRepository extends BaseRepository
{
    protected $model;

    public function __construct(Bank $model) {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        return $this->model->get();
    }
}