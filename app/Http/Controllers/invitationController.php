<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;


class invitationController extends Controller
{
    public function create()
    {
        //! this part of code fetches all the events that already have an invitation then exclude them from the events passed to the creation view
        
        $invitations = Invitation::all();
        $eventsWithInvitation = array();
        foreach ($invitations as $invitation) {
            array_push($eventsWithInvitation,$invitation->eventId);
        }
        
        $eventsWithInvitation= array_values(array_unique($eventsWithInvitation));
       
        $events = Event::all()->whereNotIn('id', $eventsWithInvitation);

        return view('invitation.create',compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Event' => 'required',
            'Body' => 'required',
            'attachment' => 'file|mimes:txt,docx,doc,csv,xlx,xls,xlsx,pdf|max:2048',
        ]);

        $eventID = $request->input('Event');
        $event = Event::find($eventID);
        $body = $request->input('Body'); 

        //- Getting the attachment file and stores it's text in a content variable
        $file = $request->file('attachment');
        $filePath = null;
        $fileName = $file->getClientOriginalName();
        if($request->hasFile('attachment'))
        {
            $filePath = $file->storeAs('attachments',$fileName,'public');
        }
        
        $fileExt =$file->getClientOriginalExtension();
        

        $invitation = new Invitation(
            [
                'eventId' => $eventID,
                'object' => $body,
                'attachmentName' => $fileName,
                'attachmentPath' => $filePath,
                'attachmentExt'=>$fileExt,
            ]
        );
        $invitation->save();
        $invitation->event()->associate($event)->save();
        return redirect(route('campaign.create',compact('event')));
    }


}
   
