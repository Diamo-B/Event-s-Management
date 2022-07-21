<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [];


    //? role of this user

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //? invitation to user 

    public function invitations()
    {
        return $this->belongsToMany(invitation::class);
    }

    //? the invitation confirmations that belong to this user
    public function inviteConfirmations()
    {
        return $this->hasMany(inviteConfirmation::class);
    }

    //? the events where this user takes part
    public function events()
    {
        return $this->belongsToMany(event::class);
    }

    //? campaigns of this user
    public function campaigns()
    {
        return $this->belongsToMany(campaigns::class);
    }
}
