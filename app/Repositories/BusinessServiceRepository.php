<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\Business;
use App\Models\Service;
use App\Models\BusinessService;

class BusinessServiceRepository extends BaseRepository
{
    protected $model;

    public function __construct(BusinessService $model) {
        $this->model = $model;
    }

    public function store($request)
    {
        $business = Business::find($request->business_id);
        if (! $business) {
            return response()->json(['message' => 'Business not found.'], 404);
        }
        elseif ($business->user_id != $request->user()->id) {
            return response()->json(['message' => 'Business does not belongs to the user.'], 422);
        }
        elseif (! Service::find($request->service_id)) {
            return response()->json(['message' => 'Service not found.'], 404);
        }
        else {
            return $this->model->create(['business_id' => $request->business_id, 'service_id' => $request->service_id]);
        }
    }

    public function destroy($id)
    {
        $business_service = $this->model->find($id);
        if (! $business_service) {
            return response()->json(['message' => 'Business service not found.'], 404);
        } else {
            $business_service->delete();
            return response()->json(['message' => 'Business service deleted successfully.'], 201);
        }
        
    }
}