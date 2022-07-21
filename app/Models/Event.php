<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $guarded = [];
    

    //? the users who take part in this event
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function confirmations()
    {
        return $this->hasMany(inviteConfirmation::class);
    }

    public function invitation()
    {
        return $this->hasOne(invitation::class);
    }
}
