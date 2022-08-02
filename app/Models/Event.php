<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];
    
    protected $fillable = [
        'title',
        'object',
        'startingAt',
        'endingAt',
        'location',
        'room',
    ];
    //? the users who take part in this event
    public function users()
    {
        return $this->belongsToMany(User::class,'event_user','eventId', 'userId');
    }

    public function inviteConfirmations()
    {
        return $this->hasMany(inviteConfirmation::class);
    }

    public function invitation()
    {
        return $this->hasOne(invitation::class);
    }

    public function Campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
