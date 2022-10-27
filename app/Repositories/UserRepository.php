<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Models\Address;
use App\Models\File;

use App\Notifications\PinRequested;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function index($request)
    {
        $users = $this->model->with('business', 'address.state', 'status')->where('is_admin', 0);

        if ($request->get('status_id')) {
            $users->where('status_id', $request->get('status_id'));
        }

        if ($request->get('has_business')) {
            if ($request->get('has_business') == 1) {
                $users->has('business');
            } else {
                $users->doesntHave('business');
            }
        }

        if ($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $users->where(function($user) use($keyword) {
                $user->where('name', 'like', '%'.$keyword.'%')->orWhere('email', 'like', '%'.$keyword.'%');
            });
        }

        return $users->get();
    }
    
    public function register($request)
    {
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            $data = Arr::only($request->all(), ['name', 'email', 'contact']);
            $data['password'] = Hash::make($request->password);

            $user = User::create($data);
            event(new Registered($user));

            return response()->json(['message' => 'We have sent you a verification email. Head to your email and verify to continue.'], 201);
        } else {
            return response()->json(['message' => 'Email is already being used by another user.'], 422);
        }
    }

    public function login($request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 422);
        }

        if ($user->is_admin == 1) {
            return response()->json(['message' => 'Admin must use web portal to login.'], 422);
        }

        if (! $user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Please verify your email before attempting to login.'], 422);
        }
    
        $user->tokens()->delete();
        return ['user' => $user->load(['business', 'address.state', 'status']), 'token' => $user->createToken($request->device_name)->plainTextToken];
    }

    public function getData($request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'User token is invalid'], 422);
        }
        elseif ($user->status_id == 3) {
            return response()->json(['message' => 'Your account is suspended, please contact the admin.'], 422);
        }

        return $user->load(['business', 'address.state', 'status']);
    }

    public function resendVerification($request)
    {
        $user = User::where('email', $request->email)->first();
    
        if (! $user) {
            return response()->json(['message' => 'We do not recognize your email.'], 422);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['info' => 'Email have already been verified.'], 201);
        }

        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'We sent a fresh verification email. Head to your email and verify to continue.'], 201);
    }

    public function logout($request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'You have been logged out from '.config('app.name').'.'], 201);
    }

    public function update($request, $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found.'], 422);
        }

        $data = $request->user;
        $image = $request->image;
        $ic = $request->ic;
        if (isset($image) && !empty($image['secure_url'])) {
            $img = File::create($image);
            $data['profile_pic_id'] = $img->id;
        }

        if (isset($ic) && !empty($ic['secure_url'])) {
            $ic = File::create($ic);
            $data['ic_id'] = $ic->id;
        }

        if ($request->user()->is_admin != 1) {
            $data['status_id'] = 1;
        }
        $user->update($data);

        if (isset($request->user['address']) && $request->user['address']) {
            Address::updateOrCreate(
                ['user_id' => $id],
                $request->user['address']
            );
        }

        return ['user' => $user->load(['business', 'address.state', 'profile_pic', 'ic', 'status']), 'message' => 'Information updated successfully. Please wait for admin to verify the submitted info.'];
    }

    public function getPin($request)
    {
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            return response()->json(['message' => 'User Not Found'], 422);
        } else {
            $pin = mt_rand(100000, 999999);
            $user->notify(new PinRequested($user, $pin));
            return ['pin' => $pin, 'message' => 'Security Pin have been emailed to you successfully'];
        }
    }

    public function resetPassword($request)
    {
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);
        return ['message' => 'Password changed successfully'];
    }

    public function getCards($request)
    {
        $user = $request->user();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripeCustomer = $user->createOrGetStripeCustomer();
        return $stripe->customers->allSources(
            $stripeCustomer->id,
            ['object' => 'card', 'limit' => 10]
        );
    }
}
