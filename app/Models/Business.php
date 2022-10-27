<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact', 'user_id', 'logo_id', 'ssm_id', 'status_id'
    ];

    protected $with = ['logo', 'ssm'];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\BusinessAddress');
    }

    public function business_services()
    {
        return $this->hasMany('App\Models\BusinessService');
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'business_services', 'business_id', 'service_id');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\BusinessService');
    }

    public function service_requests()
    {
        return $this->hasMany('App\Models\ServiceRequest');
    }

    public function ratings()
    {
        return $this->hasManyThrough('App\Models\Rating', 'App\Models\ServiceRequest', 'business_id', 'service_request_id', 'id', 'id');
    }

    public function logo()
    {
        return $this->belongsTo('App\Models\File', 'logo_id');
    }

    public function ssm()
    {
        return $this->belongsTo('App\Models\File', 'ssm_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\BusinessStatus', 'status_id');
    }

    public function bank_account()
    {
        return $this->hasOne('App\Models\BusinessBankAccount');
    }
}
