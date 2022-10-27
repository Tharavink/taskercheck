<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating', 'review', 'service_request_id'
    ];

    public function service_request()
    {
        return $this->belongsTo('App\Models\ServiceRequest', 'service_request_id');
    }
}
