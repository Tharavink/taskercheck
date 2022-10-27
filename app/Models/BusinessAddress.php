<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_1', 'line_2', 'city', 'poscode', 'state_id', 'business_id'
    ];

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business', 'business_id');
    }
}
