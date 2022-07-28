<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'email_address',
    ];

    public function invitations()
    {
        return $this->belongsToMany(invitation::class,'email_invitation','emailId','invitationId');
    }
}
