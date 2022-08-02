<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\invitationConfirmation;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Generator\StringManipulation\Pass\Pass;

class topManagerController extends Controller
{
    public function getData(Request $request, $eventId = null)
    {
        if ($request->isMethod('POST') && isset($eventId)) //! View Participants page (Page IV) 
        {
            //^ Find all the users of all the campaigns of this event (without duplication)
            $eventCampaigns = Campaign::all()->where('eventId',$eventId)->toArray();

            $campaignsUsers = array();
            foreach ($eventCampaigns as $eventCampaign) 
            {
                $query = DB::select('select userId from campaign_user where campaignId = ?', [$eventCampaign['id']]);
                foreach ($query as $one) {
                    array_push($campaignsUsers,$one->userId);
                }
                
            }
            $campaignUsers = array_unique($campaignsUsers);
            

            //^ Find all the users who confirmed and/or attended their invitation (without duplication)
            $inviteConfStatus = invitationConfirmation::all()->where('eventId', $eventId)->toArray();
            $data = array();
            foreach ($inviteConfStatus as $inv) {
                $userData = User::find($inv['userId'])->toArray();
                array_push($data, ['User' => $userData, 'isConfirmed' => $inv['isConfirmed'], 'isPresent' => $inv['isPresent']]);
            }
            
            //^ Find all the users who didn't confirm their invitation (without duplication)
            $nonConfirmedIds = array();
            $ConfirmedIds = array();
            foreach ($data as $confirmedUser) 
            {
                array_push($ConfirmedIds,$confirmedUser['User']["id"]);
            }

            $nonConfirmedIds = array_values(array_diff($campaignUsers,$ConfirmedIds));  
    
            $nonConfirmedData = array();
    
            foreach ($nonConfirmedIds as $id)
            {
                $user = User::find($id)->toArray();
                array_push($nonConfirmedData,$user);
            }
           
            return view('TopManager.chooseEvent', compact('data','nonConfirmedData'));
        } 


        else if ($request->isMethod('POST')) //! Event's Details Page (Page II)
        {
            $EventId = $request->input("Event");
            $details = \App\Models\Event::find($EventId);
            return view('TopManager.chooseEvent', compact('details'));
        } 
        
        else if (isset($eventId)) //! Campaign Details Page (Page III)
        {
            $event = \App\Models\Event::all()->where('id', $eventId)->toArray();
            $event = array_reduce($event, 'array_merge', array()); // turning it into a simple 'one-layer' associative arr

            $Campaigns = Campaign::all()->where('eventId', $eventId);

            $campaignCount = $Campaigns->count();
            $campaignRelaunchNumber = $Campaigns->where('status', 'Relanch')->count();
            $campaignComplementNumber = $Campaigns->where('status', 'Complement')->count();

            return view('TopManager.chooseEvent', compact('event', 'Campaigns', 'campaignCount', 'campaignRelaunchNumber', 'campaignComplementNumber'));
        } 
        
        else //! Choose an Event Page (Page I)
        {
            $dt = Carbon::now()->format("Y-m-d H:i:s");
            $events = DB::select('select * from events order By id DESC');
            
            $onGoingEvents = array();
            $endedEvents = array();
            foreach ($events as $event) 
            {
                $ending = new DateTime($event->endingAt);
                if ($ending>Carbon::now()) 
                {
                    array_push($onGoingEvents,$event);
                }
                else
                {
                    array_push($endedEvents,$event);
                }
            }
            $route = Route::current()->getName();

            if ($route == 'realTimeData') 
            {
                $events = $onGoingEvents;
            }
            else if($route == 'history')
            {
                $events = $endedEvents;
            }

            

            return view('TopManager.chooseEvent', compact('events'));
        }
    }
}
