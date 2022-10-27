<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_1', 'line_2', 'city', 'poscode', 'state_id', 'user_id'
    ];

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Business', 'user_id');
    }
}
