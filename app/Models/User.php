<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'status_id',
        'profile_pic_id',
        'ic_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'is_admin'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $with = ['profile_pic', 'ic'];

    public function business()
    {
        return $this->hasOne('App\Models\Business');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    public function service_requests()
    {
        return $this->hasMany('App\Models\ServiceRequest');
    }

    public function conversations()
    {
        return $this->belongsToMany('App\Models\Conversation', 'conversation_users', 'user_id', 'conversation_id');
    }

    public function chats()
    {
        return $this->hasMany('App\Models\Chat');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\UserStatus', 'status_id');
    }

    public function profile_pic()
    {
        return $this->belongsTo('App\Models\File', 'profile_pic_id');
    }

    public function ic()
    {
        return $this->belongsTo('App\Models\File', 'ic_id');
    }

    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }
}
