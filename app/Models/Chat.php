<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'message', 'is_bot', 'user_id', 'img_id', 'conversation_id'
    ];
    protected $appends = ['image'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function conversation()
    {
        return $this->belongsTo('App\Models\Conversation', 'conversation_id');
    }

    public function recipient()
    {
        return $this->hasMany('App\Models\ChatRecipient');
    }

    public function img()
    {
        return $this->belongsTo('App\Models\File', 'img_id');
    }

    public function getImageAttribute()
    {
        if ($this->img_id) {
            return $this->img->file_url;
        } else {
            return null;
        }
        
    }
}
