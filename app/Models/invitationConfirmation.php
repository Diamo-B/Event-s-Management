<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invitationConfirmation extends Model
{
    use HasFactory;
    public $timestamps = false; //by default timestamp true
    protected $guarded = [];  

    //? the user who issued this confirmation 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(event::class);
    }
}
