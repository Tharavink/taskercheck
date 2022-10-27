<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'status_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\ServiceStatus', 'status_id');
    }

    public function business_services()
    {
        return $this->hasMany('App\Models\BusinessService');
    }

    public function businesses()
    {
        return $this->belongsToMany('App\Models\Business', 'business_services', 'service_id', 'business_id');
    }

    public function service_requests()
    {
        return $this->hasMany('App\Models\ServiceRequest');
    }
}
