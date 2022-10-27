<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestStatus;
use App\Models\Card;

use App\Events\RequestUpdated;

class ServiceRequestRepository extends BaseRepository
{
    protected $model;

    public function __construct(ServiceRequest $model) {
        $this->model = $model;
    }

    public function index($request, $is_api=0)
    {
        $requests = $this->model->with('service', 'business.owner', 'business.bank_account.bank', 'requester.address.state', 'status');

        if ($request->get('status_id')) {
            $requests->where('status_id', $request->get('status_id'));
        }

        if ($request->get('service_id')) {
            $requests->where('service_id', $request->get('service_id'));
        }

        if ($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $requests->whereHas('business', function($business) use($keyword) {
                $business->where('name', 'like', '%'.$keyword.'%');
            });
        }

        if (! $is_api) {
            return $requests->get();
        } else {
            $user = $request->user();
            if (! $request->is_business) {
                return $requests->where('user_id', $user->id)->orderBy('id', 'DESC')->get();
            } else {
                return $requests->whereHas('business', function($business) use ($user) {
                    $business->where('user_id', $user->id);
                })->orderBy('id', 'DESC')->get();
            }
        }
    }

    public function store($request)
    {
        $this->model->create($request->all());
        return response()->json(['message' => 'Booking made successfully. Please wait for the service provider to respond.'], 201);
    }

    public function show($id)
    {
        return $this->model->with('conversation', 'service', 'business.owner', 'business.address.state', 'requester.address.state', 'status', 'rating')->find($id);
    }

    public function update($request, $id)
    {
        if ($this->model->find($id)->update($request->all())) {

            $service_request = $this->show($id);
            event(new RequestUpdated($service_request));
            return $service_request;
        } else {
            return response()->json(['message' => 'Service request cannot be updated.'], 422);
        }
    }

    public function getStatusses()
    {
        return ServiceRequestStatus::all();
    }

    public function pay($request, $id)
    {
        $user = $request->user();
        $service_request = $this->model->find($id);
        $stripeCustomer = $user->createOrGetStripeCustomer();

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            
        if (isset($request->card_id) && !empty($request->card_id)) {
            $card_id = $request->card_id;
        }
        else {
            $stripe->customers->createSource(
                $stripeCustomer->id,
                ['source' => $request->id]
            );
            $card_id = $request->card['id'];
        }
        
        $stripe->charges->create([
            'amount' => ($service_request->amount * 100),
            'currency' => 'myr',
            'source' =>  $card_id,
            'customer' => $stripeCustomer->id,
            'description' => $service_request->service->name.' service from '.$service_request->business->name,
        ]);

        $service_request->update(['status_id' => 3]);

        $service_request = $this->show($id);
        event(new RequestUpdated($service_request));
        return $service_request;
    }
}
