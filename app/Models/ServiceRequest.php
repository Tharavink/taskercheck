<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'business_id', 'user_id', 'service_time', 'is_paid', 'amount', 'status_id'
    ];

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business', 'business_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ServiceRequestStatus', 'status_id');
    }

    public function requester()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function conversation()
    {
        return $this->hasOne('App\Models\Conversation');
    }

    public function rating()
    {
        return $this->hasOne('App\Models\Rating');
    }
}
