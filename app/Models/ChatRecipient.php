<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'chat_id', 'delivered', 'read'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    } 

    public function chat()
    {
        return $this->belongsTo('App\Chat', 'chat_id');
    }
}
