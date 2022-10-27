<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WEB\UserController;
use App\Http\Controllers\WEB\ServiceController;
use App\Http\Controllers\WEB\ServiceRequestController;
use App\Http\Controllers\WEB\BusinessController;
use App\Http\Controllers\WEB\HomeController;

use App\Models\User;
use App\Models\UserStatus;
use App\Models\Service;
use App\Models\ServiceStatus;
use App\Models\ServiceRequestStatus;
use App\Models\BusinessStatus;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('mobile/login', function () {
    return view('email-verified');
})->name('mobile.login');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::find($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return view('email-verified',  ['status' => 0]);
    }

    if ($user->markEmailAsVerified())
        return view('email-verified', ['status' => 1]);
    else 
        return view('email-verified',  ['status' => 0]);
})->middleware(['signed'])->name('verification.verify');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');

    Route::get('/dashboard/user', function () {
        return Inertia\Inertia::render('User/Dashboard', [
            'user_index_route' => route('user.index'),
            'user_statusses' => UserStatus::all()
        ]);
    })->name('dashboard');

    Route::resource('service', ServiceController::class)->names([
        'index'     => 'service.index',
        'create'    => 'service.create',
        'store'     => 'service.store',
        'show'      => 'service.show',
        'edit'      => 'service.edit',
        'update'    => 'service.update',
        'destroy'   => 'service.destroy'
    ]);

    Route::get('/dashboard/service', function () {
        return Inertia\Inertia::render('Service/Dashboard', [
            'service_index_route' => route('service.index'),
            'service_statusses' => ServiceStatus::all()
        ]);
    })->name('service');

    Route::resource('request', ServiceRequestController::class)->names([
        'index'     => 'request.index',
        'create'    => 'request.create',
        'store'     => 'request.store',
        'show'      => 'request.show',
        'edit'      => 'request.edit',
        'update'    => 'request.update',
        'destroy'   => 'request.destroy'
    ]);

    Route::get('/dashboard/request', function () {
        return Inertia\Inertia::render('ServiceRequest/Dashboard', [
            'requests_index_route' => route('request.index'),
            'requests_statusses' => ServiceRequestStatus::all(),
            'services' => Service::all()
        ]);
    })->name('requests');

    Route::resource('business', BusinessController::class)->names([
        'index'     => 'business.index',
        'create'    => 'business.create',
        'store'     => 'business.store',
        'show'      => 'business.show',
        'edit'      => 'business.edit',
        'update'    => 'business.update',
        'destroy'   => 'business.destroy'
    ]);

    Route::get('/dashboard/business', function () {
        return Inertia\Inertia::render('Business/Dashboard', [
            'business_index_route' => route('business.index'),
            'business_statusses' => BusinessStatus::all()
        ]);
    })->name('business');
});