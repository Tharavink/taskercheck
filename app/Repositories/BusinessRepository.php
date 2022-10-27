<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\Business;
use App\Models\BusinessAddress;
use App\Models\BusinessService;
use App\Models\File;
use App\Models\BusinessBankAccount;

class BusinessRepository extends BaseRepository
{
    protected $model;

    public function __construct(Business $model) {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $businesses = $this->model->with('owner', 'status', 'bank_account.bank', 'address.state', 'services', 'service_requests.service', 'service_requests.status', 'service_requests.requester.address', 'ratings');

        $businesses->whereHas('owner', function($owner) {
            $owner->where('status_id', 2);
        });

        if ($request->user()->is_admin) {
            if ($request->status_id) {
                $businesses->where('status_id', $request->status_id);
            }
        } else {
            $businesses->where('status_id', 2);
        }

        if ($request->service_id) {
            $service_id = $request->service_id;
            $businesses->whereHas('services', function($service_id) {
                $service->where('id', $service_id);
            });
        }

        if ($request->serviceIds) {
            $service_ids = $request->serviceIds;
            if (!empty($service_ids)) {
                $businesses->whereHas('services', function($service) use($service_ids) {
                    $service->whereIn('services.id', $service_ids);
                });
            }
        }

        if ($request->stateIds) {
            $state_ids = $request->stateIds;
            if (!empty($state_ids)) {
                $businesses->whereHas('address', function($address) use($state_ids) {
                    $address->whereIn('state_id', $state_ids);
                });
            }
        }

        if ($request->keyword) {
            $businesses->where('name', 'like', '%'.$request->keyword.'%');
        }

        return $businesses->get();
    }

    public function store($request)
    {
        $business = $request->business;
        $address = $business['address'];
        $prices = $business['prices'];

        if (!empty($business['bank_account'])) {
            $acc = $business['bank_account'];
        } else {
            $acc = null;
        }

        $data = Arr::only($business, ['name', 'contact', 'user_id']);
        $data['user_id'] = !empty($data['user_id']) ? $data['user_id'] : $request->user()->id;

        $logo = $request->logo;
        $ssm = $request->ssm;
        if (isset($logo) && !empty($logo['secure_url'])) {
            $logo_file = File::create($logo);
            $data['logo_id'] = $logo_file->id;
        }

        if (isset($ssm) && !empty($ssm['secure_url'])) {
            $ssm_file = File::create($ssm);
            $data['ssm_id'] = $ssm_file->id;
        }

        $business = $this->model->create($data);

        if ($prices && !empty($prices)) {
            foreach ($prices as $key => $price) {
                BusinessService::create([
                    'business_id' => $business->id,
                    'service_id' => $price['service_id'],
                    'min' => $price['min'],
                    'max' => $price['max']
                ]);
            }
        }
        
        $address['business_id'] = $business->id;
        BusinessAddress::create($address);

        if ($acc) {
            $acc['business_id'] = $business->id;
            BusinessBankAccount::create($acc);
        }

        return response()->json(['message' => 'Business created successfully. Please wait for admin to verify the changes.', 'business' => $this->show($business->id)], 201);
    }

    public function show($id)
    {
        return $this->model->with('owner', 'status', 'bank_account.bank', 'address.state', 'services', 'prices.service', 'service_requests.service', 'service_requests.status', 'service_requests.requester.address.state', 'service_requests.rating', 'ratings')->find($id);
    }

    public function update($request, $id)
    {
        $business = $request->business;
        
        if (!empty($business['address'])) {
            $address = $business['address'];
        }
        else {
            $address = null;
        }

        if (!empty($business['bank_account'])) {
            $acc = $business['bank_account'];
        } else {
            $acc = null;
        }
        
        if (!empty($business['prices'])) {
            $prices = $business['prices'];
        }
        else {
            $prices = null;
        }

        $data = Arr::only($request->business, ['name', 'contact', 'user_id', 'status_id']);

        $logo = $request->logo;
        $ssm = $request->ssm;
        if (isset($logo) && !empty($logo['secure_url'])) {
            $logo_file = File::create($logo);
            $data['logo_id'] = $logo_file->id;
        }

        if (isset($ssm) && !empty($ssm['secure_url'])) {
            $ssm_file = File::create($ssm);
            $data['ssm_id'] = $ssm_file->id;
        }

        if ($request->user()->is_admin != 1) {
            $data['status_id'] = 1;
        }

        $this->model->find($id)->update($data);
        
        if ($prices && !empty($prices)) {
            BusinessService::where('business_id', $id)->delete();
            foreach ($prices as $key => $price) {
                BusinessService::create($price);
            }
        }
        
        if ($address) {
            $address['business_id'] = $id;
            $businessAddress = BusinessAddress::where('business_id', $id)->first();
            if (! $businessAddress) {
                BusinessAddress::create($address);
            } else {
                $businessAddress->update($address);
            }
        }

        if ($acc) {
            $acc['business_id'] = $id;
            BusinessBankAccount::create($acc);
        }

        return response()->json(['message' => 'Business info updated successfully. Please wait for admin to verify the changes.', 'business' => $this->show($id)], 201);
    }
}