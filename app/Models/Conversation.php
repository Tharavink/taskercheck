<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_id'
    ];

    public function service_request()
    {
        return $this->belongsTo('App\Models\ServiceRequest', 'service_request_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'conversation_users', 'conversation_id', 'user_id');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\Chat')->orderBy('id', 'DESC');
    }

    public function latest()
    {
        return $this->hasOne(\App\Models\Chat::class)->latest();
    }
}
