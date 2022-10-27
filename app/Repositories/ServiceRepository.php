<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\Service;

class ServiceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Service $model) {
        $this->model = $model;
    }

    public function index($request=null)
    {
        $services = $this->model->with('status');

        if ($request->user()->is_admin) {
            if ($request->get('status_id')) {
                $services->where('status_id', $request->get('status_id'));
            }
    
            if ($request->get('keyword')) {
                $keyword = $request->get('keyword');
                $services->where('name', 'like', '%'.$keyword.'%');
            }
        } else {
            $services->where('status_id', 1);
        }

        return $services->get();
    }

    public function store($request=null)
    {
        $service = $this->model->create($request->service);
        return $this->model->with('status')->find($service->id);
    }

    public function show($id)
    {
        $service = $this->model->with('status')->find($id);
        if (is_null($service)) {
            return response()->json(['message' => 'Service not found'], 404);
        } else {
            return $service;
        }
    }

    public function update($request, $id)
    {
        $service = $this->model->find($id);

        if (! $service) {
            return response()->json(['message' => 'User not found.'], 422);
        }

        $service->update($request->service);
        return response()->json(['message' => 'User details have been updated successfully.', 'service' => $this->model->with('status')->find($id)], 201);
    }
}
