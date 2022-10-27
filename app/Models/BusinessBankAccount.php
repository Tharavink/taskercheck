<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessBankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_id', 'acc_number', 'acc_name', 'business_id'
    ];

    public function business()
    {
        return $this->belongsTo('App\Models\Business', 'business_id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id');
    }
}
