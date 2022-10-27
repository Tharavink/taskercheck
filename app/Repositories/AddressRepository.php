<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\Address;
use App\Models\State;

class AddressRepository extends BaseRepository
{
    protected $model;

    public function __construct(Address $model) {
        $this->model = $model;
    }

    public function store($request)
    {
        return $this->model->create($request->all());
    }

    public function destroy($id)
    {
        $address = $this->model->find($id);
        if (! $address) {
            return response()->json(['message' => 'Address data not found.'], 404);
        } else {
            $address->delete();
            return response()->json(['message' => 'Address deleted successfully.'], 201);
        }
    }

    public function getStates()
    {
        return State::all();
    }
}