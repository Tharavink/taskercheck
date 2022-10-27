<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'state'
    ];

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function business_addresses()
    {
        return $this->hasMany('App\BusinessAddress');
    }
}
