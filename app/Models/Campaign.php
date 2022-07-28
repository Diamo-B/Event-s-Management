<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    public $timestamps = false; //by default timestamp true
    public function setCreatedAtAttribute($value) { 
        $this->attributes['created_at'] = \Carbon\Carbon::now(); 
    }
    protected $guarded = [];  

    public function users()
    {
        return $this->belongsToMany(User::class,'campaign_user','campaignId','userId');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'eventId');
    }

    public function Invitation()
    {
        return $this->belongsTo(Invitation::class,'invitationId');
    }

}
