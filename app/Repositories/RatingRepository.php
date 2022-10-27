<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\Rating;

use App\Repositories\ServiceRequestRepository;
use App\Events\RequestUpdated;

class RatingRepository extends BaseRepository
{
    protected $model;
    protected $request_repository;

    public function __construct(Rating $model, ServiceRequestRepository $request_repository) {
        $this->model = $model;
        $this->request_repository = $request_repository;
    }

    public function store($request)
    {
        $rating = $this->model->create($request->all());
        event(new RequestUpdated($this->request_repository->show($rating->service_request_id)));
        return $rating;
    }
}