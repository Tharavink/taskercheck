<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessService extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'service_id', 'min', 'max'
    ];

    public function business()
    {
        return $this->belongsTo('App\Models\Business', 'business_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }
}
