<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailOfthisRecipient;
    public $CampaignStatus;
    public $invitationData;
    public $eventData;
    public $campaignData;
    public $dataRecipient;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$recipient,$status,$invitation,$event,$Campaign)
    {
        $this->dataRecipient = $data;             //^ done
        $this->emailOfthisRecipient = $recipient;    //^ done
        $this->CampaignStatus = $status;            //^ done
        $this->invitationData = $invitation;       //^ done
        $this->eventData = $event;                //^ done
        $this->campaignData = $Campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Invitation')->view('emails.InvitationMail');
    }
}
