<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\invitationConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DateTime;


class invitationController extends Controller
{
    public function create()
    {
        //! this part of code fetches all the events that already have an invitation then exclude them from the events passed to the creation view

        $invitations = Invitation::all();
        $eventsWithInvitation = array();
        foreach ($invitations as $invitation) {
            array_push($eventsWithInvitation, $invitation->eventId);
        }

        $eventsWithInvitation = array_values(array_unique($eventsWithInvitation));

        $events = Event::all()->whereNotIn('id', $eventsWithInvitation);

        $notStartedYetEvents = array();
        foreach ($events as $event) 
        {
            $starting = new DateTime($event->startingAt);
            if($starting > Carbon::now('GMT+1'))
            {
                array_push($notStartedYetEvents,$event);
            }
        }
        $events = $notStartedYetEvents;
    
        return view('invitation.create', compact('events'));
    }






    public function store(Request $request)
    {
        $request->validate([
            'Event' => 'required',
            'Body' => 'required',
            'attachment' => 'file|mimes:txt,docx,doc,csv,xlx,xls,xlsx,pdf',
        ]);
        

        $eventID = $request->input('Event');
        $event = Event::find($eventID);
        $body = $request->input('Body');

        //- Getting the attachment file and stores it's text in a content variable
        $file = $request->file('attachment');
        $filePath = null;
        $fileName = $file->getClientOriginalName();
        if ($request->hasFile('attachment')) {
            $filePath = $file->storeAs('attachments', $fileName, 'public');
        }

        $fileExt = $file->getClientOriginalExtension();


        $invitation = new Invitation(
            [
                'eventId' => $eventID,
                'object' => $body,
                'attachmentName' => $fileName,
                'attachmentPath' => $filePath,
                'attachmentExt' => $fileExt,
            ]
        );
        $invitation->save();
        $invitation->event()->associate($event)->save();
        return redirect(route('campaign.create', compact('event')));
    }



    /*
        *  Accepts an invitation
        ^  @param Request $request
        ^  @param Event $event
        => @return invitationConfirmation
    */

    public function AcceptInvite($token)
    {
        $event_user = DB::select('select * from event_user where inviteToken = ?', [$token])[0];

        $eventId = $event_user->eventId;
        $event = Event::find($eventId);

        $userId = $event_user->userId;
        $user = User::find($userId);

        $checkExistConfirm = DB::select('SELECT * from invitation_confirmations where eventId = ? and userId = ?', [$eventId, $userId]);
        if (count($checkExistConfirm) === 0) {
            $inviteConfirmation = new invitationConfirmation([
                'isConfirmed'   => true,
                'isPresent'     => false,
            ]);
            $inviteConfirmation->save();
            $inviteConfirmation->user()->associate($user)->save();
            $inviteConfirmation->event()->associate($event)->save();
        }
        return view('inviteConfirmation');
    }

    public function index(Request $request)
    {
        //- First check if the form is submited
        if ($request->input('Events') == null) {
            //^ If not: We are taking only the events that already have an invitation by following these steps:

            //=> First fetch all the invitations
            $invitations = Invitation::all();

            //=> second create an array to hold the id of the events that already have an invitation 
            $eventsWithInvitation = array();

            //=> next, loop over all the invitations and store each invitation's eventId in the eventsWithInvitation array
            foreach ($invitations as $invitation) {
                array_push($eventsWithInvitation, $invitation->eventId);
            }
            
            //=> finally we fetch all the events that the $eventsWithInvitation array contain their Id
            $events = Event::all()->whereIn('id', $eventsWithInvitation);
            $Inv = true;
            return view('ChooseEvent', compact('events','Inv'));

        } else 
        {
            //^ If the form was submited: We need to show the invitation object and attachment name, a link to download it and a link to delete it
            
            $eventId = $request->input('Events');
            $event = \App\Models\Event::find($eventId)->toArray();

            //=> fetch the invitation data of this event
            $invitation = array_values(Invitation::all()->where('eventId',$eventId)->toArray())[0]; //? array_values is used to re-index the resulting array so it always have an index equal to '0' because the query by default return an array that have the invitation Id as the index
            
            return view('invitation.viewInvitations',compact('invitation','event'));
        }
    }

    public function download($attachment)
    {
        $file = Storage::disk('public')->get($attachment);
  
        return Storage::download('/public/attachments/'.$attachment,$attachment);
    }

    public function delete($id)
    {
        $invite = Invitation::all()->where('id',$id);
        $this->deleteFileFromStorage($invite->toArray()[0]['attachmentPath']);
        Invitation::where('id',$id)->delete();
        return back();
    }

    public function deleteFileFromStorage($filePath)
    {
        $fullFilePath = '/public/'.$filePath;
        if(Storage::exists($fullFilePath))
        {
            Storage::delete($fullFilePath);
        }else
        {
            dd('File does not exists.');
        }
    }
}
