<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand', 'exp_month', 'exp_year', 'last4', 'stripe_id', 'token', 'user_id'
    ];
}
