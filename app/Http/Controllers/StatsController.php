<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use Brick\Math\Exception\DivisionByZeroException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DivisionByZeroError;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use function PHPUnit\Framework\isNull;

class StatsController extends Controller
{
    public function paginate(Request $request, $items, $perPage = 2, $page = null, $options=[])
    {
        $page = isset($request->page) ? $request->page : 1; // Get the page=1 from the url
        /* $page = $page ?: (Paginator::resolveCurrentPage() ?: 1); */
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage), $items->count(), $perPage, $page,
            ['path' => $request->url()],
        );
    }

    public function DataStats(Request $request)
    {
        if ($request->isMethod('POST')) 
        {
            return $this->ShowStats($request);
        } else 
        {
            $type = 'DataStat';
            $notStartedOrOngoingEvents = \App\Models\Event::all()->where('endingAt', '>', Carbon::now('GMT+1')); //=> the events that have not started yet or on going
            $events = array();
            foreach ($notStartedOrOngoingEvents as $event) {
                $X = Campaign::all()->where('eventId',$event->id)->toArray(); 
                if (!empty($X))
                {
                    array_push($events,$event);
                }
            }
            $events = $this->paginate($request,$events);
            $data = $request->all();
            $search = true;
            return view('events.show', compact('events', 'type', 'data','search'));
        }
    }

    public function HistoryStats(Request $request)
    {
        if ($request->isMethod('POST')) {
            return $this->ShowStats($request);
        } else {
            $type = 'HistoryStat';
            $endedEvents = \App\Models\Event::all()->where('endingAt', '<=', Carbon::now('GMT+1')); //=> the events that have ended
            $events = array();
            foreach ($endedEvents as $event) 
            {
                $X = Campaign::all()->where('eventId',$event->id)->toArray(); 
                if (!empty($X))
                {
                    array_push($events,$event);
                }
            }
            $events = $this->paginate($request,$events);
            $data = $request->all();
            $search = true;
            return view('events.show', compact('events', 'type','data','search'));
        }
    }



    public function ShowStats(Request $request)
    {
        
        //! get all the ids of the users that have 'participant' as their role
        $participantIds = array();
        $participants = User::all()->where('roleId', 3)->toArray();
        foreach ($participants as $participant) {
            array_push($participantIds, $participant['id']);
        }
        $participantIds = array_values($participantIds);

        //------------------------------------------------------------------------------------------------------------------------------------------
        $eventId = $request->input('Events');
        
        $event = array_values(\App\Models\Event::all()->where('id', $eventId)->toArray())[0]; //=> The event itself
        $Campaigns =  array_values(Campaign::all()->where("eventId", $eventId)->toArray()); //=> Every single Campaign of this event
        //dd($eventId,$event,$Campaigns);
        //! store the userIds of every Campaign into one single array without duplications (find the invited users)
        $CampaignsUserIds = array();
        foreach ($Campaigns as $Camp) {
            $CampaignId = $Camp["id"];
            array_push($CampaignsUserIds, DB::select('select userId from campaign_user where campaignId = ?', [$CampaignId]));
        }
        $CampaignsUserIds = array_reduce($CampaignsUserIds, 'array_merge', array());
        $userIds = array();
        foreach ($CampaignsUserIds as $UserId) {
            array_push($userIds, $UserId->userId);
        }

        $invitedUsersIds = array_values(array_unique($userIds)); //? the array containing the Ids of all the users of every campaign without duplications
        $invitedUsersCount = count(array_values(array_unique($userIds))); //? the final array with the number of userIds who got an invitation

        //! Now we need to find all the users who actually accepted the invitation
        $acceptedUsersIds = array();
        $userIdsAccepted = DB::select('select userId from invitation_confirmations where eventId = ? and isConfirmed = 1', [$eventId]);
        foreach ($userIdsAccepted as $id) {
            array_push($acceptedUsersIds, $id->userId);
        }
        $acceptedUsersIds = array_values($acceptedUsersIds);
        $acceptedUsersCount = count($acceptedUsersIds);

        //! Now we need to find all the users who actually attended the event
        $attendedUsersIds = array();
        $userIdsAttended = DB::select('select userId from invitation_confirmations where eventId = ? and isPresent = 1', [$eventId]);
        foreach ($userIdsAttended as $id) {
            array_push($attendedUsersIds, $id->userId);
        }
        $attendedUsersIds = array_values($attendedUsersIds);
        $attendedUsersCount = count($attendedUsersIds);


        //dd("participantIds",$participantIds,'participantsCount',count($participantIds),'invitedUsersIds',$invitedUsersIds,'invitedUsersCount',$invitedUsersCount,'acceptedUsersIds',$acceptedUsersIds,'acceptedUsersCount',$acceptedUsersCount,'attendedUsersIds',$attendedUsersIds,'attendedUsersCount',$attendedUsersCount);
        //! now moving into the different rates
        try 
        {
            $userInvitationRate = ($invitedUsersCount / count($participantIds)) * 100;        //? the invited users compared to the totality of the participants
            $eventAttendance_Total = ($attendedUsersCount / count($participantIds)) * 100;   //? the atteded users compared to the the totality of the participants
        } catch (DivisionByZeroError $err) 
        {
            return back()->withError('Aucun utilisateur réel avec le rôle participant dans la base de données');
        }
        try 
        {
            $invitationConfirmationRate = ($acceptedUsersCount / $invitedUsersCount) * 100;  //? the confirmed users compared to the invited users
            $eventAttendanceRate = ($attendedUsersCount / $invitedUsersCount) * 100;        //? the attended users compared to the invited users
        } catch (DivisionByZeroError $err) 
        {
            return back()->withError('Aucun utilisateur n\'a été invité à l\'événement "'.$event['title'].'"');
        }

        /*
        *   $participantIds      #type: array   #description : the Ids of all the users with the role of 'participant'
        *   $event               #type: array   #description : the event's data 
        *   $invitedUsersIds     #type: array   #description : The Ids of all the invited users
        *   $invitedUsersCount   #type: int     #description : the count of all the invited users (the count of the previous array)
        *   $acceptedUsersIds    #type: array   #description : The Ids of all the users who accepted their invitations
        *   $acceptedUsersCount   #type: int     #description : the count of all the users who accepted their invitations (the count of the previous array)
        *   $attendedUsersIds    #type: array   #description : the Ids of all the users who attended the event
        *   $attendedUsersCount  #type: int     #description : the count of all the users who attended the event
        */


        
        return view('Stats.actualStats', compact('participantIds', 'invitedUsersCount', 'acceptedUsersCount', 'attendedUsersCount', 'userInvitationRate', 'invitationConfirmationRate', 'eventAttendanceRate', 'eventAttendance_Total'));
    }

    public function general(Request $request)
    {
        //! events count
        $events = \App\Models\Event::all()->count(); 
        //! ongoing events count
        $ongoingEvents =  \App\Models\Event::all()->where('startingAt', '<', Carbon::now('GMT+1'))->where('endingAt', '>', Carbon::now('GMT+1'))->count(); 
        //! notStartedYet events count
        $notStartedYetEvents = \App\Models\Event::all()->where('startingAt', '>', Carbon::now('GMT+1'))->count(); 
        //! ended Events count
        $endedEvents = \App\Models\Event::all()->where('endingAt', '<=', Carbon::now('GMT+1'))->count(); 
        //! participants count
        $participants = User::all()->where('roleId',3)->count();
        //! users count
        $users = User::all()->count();
        //! invitations count
        $invites = count(DB::select('select * from event_user')); //- [II]

        //! total invitation acceptance rate (count of accepted invitations in all events[I] / count of invitations in all events[II] *100 )
        $acceptedInvites = count(DB::select('select * from invitation_confirmations where isConfirmed = 1')); //- [I]
        $acceptanceRate = ($acceptedInvites / $invites) * 100;

        //dd($acceptedInvites,$invites,$acceptanceRate);
        //! total attandance rate (count of attandance in all events[III] / count of invitations in all events[II] * 100)
        $attandanceCount = count(DB::select('select * from invitation_confirmations where isPresent = 1')); //- [III]
        $attandanceRate = ($attandanceCount / $invites) * 100;


        //! total absence rate (count of absence in all events[IV] / count of invitations in all events[II] * 100)
        $absenceCount = count(DB::select('select * from invitation_confirmations where isPresent = 0')); //- [IV]
        $absenceRate = ($absenceCount/$invites)*100;

        if($request->isMethod('post'))
        {
            $adv = true;
            return view('Stats.fullStats',compact('acceptanceRate','attandanceRate','absenceRate','adv'));
        }
        else
        {
            return view('Stats.fullStats',compact('events','ongoingEvents','notStartedYetEvents','endedEvents','participants','users','invites'));
        }
    }
}
