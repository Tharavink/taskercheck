<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'cssClass'
    ];

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }
}
