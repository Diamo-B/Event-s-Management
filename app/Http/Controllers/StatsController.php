<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Brick\Math\Exception\DivisionByZeroException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DivisionByZeroError;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function DataStats(Request $request)
    {
        if ($request->isMethod('POST')) {
            return $this->ShowStats($request);
        } else {
            $type = 'DataStat';
            $events = \App\Models\Event::all()->where('endingAt', '>', Carbon::now()); //=> the events that have not started yet or on going
            return view('TopManager.chooseEvent', compact('events', 'type'));
        }
    }

    public function HistoryStats(Request $request)
    {
        if ($request->isMethod('POST')) {
            return $this->ShowStats($request);
        } else {
            $type = 'HistoryStat';
            $events = \App\Models\Event::all()->where('endingAt', '<=', Carbon::now()); //=> the events that have ended
            return view('TopManager.chooseEvent', compact('events', 'type'));
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
        $eventId = $request->input('Event');
        $event = array_values(\App\Models\Event::all()->where('id', $eventId)->toArray())[0]; //=> The event itself
        $Campaigns =  array_values(Campaign::all()->where("eventId", $eventId)->toArray()); //=> Every single Campaign of this event

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
            return back()->withError('No Actual users with the role participant in the database ');
        }
        try 
        {
            $invitationConfirmationRate = ($acceptedUsersCount / $invitedUsersCount) * 100;  //? the confirmed users compared to the invited users
            $eventAttendanceRate = ($attendedUsersCount / $invitedUsersCount) * 100;        //? the attended users compared to the invited users
        } catch (DivisionByZeroError $err) 
        {
            return back()->withError('No Actual users were invited to the event "'.$event['title'].'"');
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


        /* dd("the participant ids:",$participantIds,"the event:",$event,"the invited users ids:",$invitedUsersIds,"invited users count:",$invitedUsersCount,'ids of the users who accepted the invitation:',$acceptedUsersIds,'the count of the users who accepted the invitation:',$acceptedUsersCount,'the users who attended the event:', $attendedUsersIds, 'the count of the users who attended the event:',$attendedUsersCount, 'the invitation rate: the invited users compared to the totality of the participants',round($userInvitationRate,PHP_ROUND_HALF_UP).'%','Rate of the users who accepted their invitations compared to the total of invited users:', round($invitationConfirmationRate,PHP_ROUND_HALF_UP).'%','Rate of the invited users who actually attended the event:',round($eventAttendanceRate,PHP_ROUND_HALF_UP).'%','Rate of the users who attended the event compared to the totality of participants:',round($eventAttendance_Total,PHP_ROUND_HALF_UP).'%'); */

        return view('TopManager.Stats.actualStats', compact('participantIds', 'invitedUsersCount', 'acceptedUsersCount', 'attendedUsersCount', 'userInvitationRate', 'invitationConfirmationRate', 'eventAttendanceRate', 'eventAttendance_Total'));
    }
}
