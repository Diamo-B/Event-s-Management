<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailOfthisRecipient;
    public $CampaignStatus;
    public $invitationData;
    public $eventData;
    public $campaignData;
    public $dataRecipient;
    public $inviteToken;
   
    
    public function __construct($data,$recipient,$status,$invitation,$event,$Campaign,$inviteToken)
    {
        
        $this->dataRecipient = $data;                 //^ done
        $this->emailOfthisRecipient = $recipient;    //^ done
        $this->CampaignStatus = $status;            //^ done
        $this->invitationData = $invitation;       //^ done
        $this->eventData = $event;                //^ done
        $this->inviteToken= $inviteToken;
        $this->campaignData = $Campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Invitation')->view('emails.InvitationMail')
        ->attach(storage_path('app\public\attachments'.'\\'.$this->invitationData['attachmentName']),['as' => $this->invitationData['attachmentName']]);
    }
}
