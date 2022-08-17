<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgotPassMail extends Mailable
{
    use Queueable, SerializesModels;
    public $rememberPasswordToken;
    public $email;

    public function __construct($rememberPasswordToken,$email)
    {
        
        $this->rememberPasswordToken = $rememberPasswordToken;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')->view('emails.resetPassword');
    }
}
