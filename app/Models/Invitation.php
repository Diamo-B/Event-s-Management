<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    public $timestamps = false; //by default timestamp true
    protected $guarded = [];  
    

    /*
        user to invitation
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function event()
    {
        return $this->belongsTo(event::class,'eventId');
    }

    public function recipientsEmail()
    {   
        return $this->belongsToMany(Email::class,'email_invitation','invitationId','emailId');
    }

    public function Campaign()
    {
        return $this->hasOne(Campaign::class);
    }
}
