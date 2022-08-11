<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\invitationConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
           $viewusers = $data;
           //dd('users:',$viewusers,'event',$eventId,'non Confirmed Data:',$nonConfirmedData);
            return view('Campaign.viewCampaign', compact('viewusers','eventId','nonConfirmedData'));
        } 


        else if ($request->isMethod('POST') && is_null($request->input('eventTitle'))) //! Event's Details Page (Page II)
        {
            $EventId = $request->input("Event");
            $details = \App\Models\Event::find($EventId);
            $Date_Time = array();
            $Sd = array();
            $Ed = array();
            $St = array();
            $Et = array();
            for ($i=0; $i<10; $i++)
            {
                array_push($Sd,$details->startingAt[$i]);
                array_push($Ed,$details->endingAt[$i]);
            }
            for ($i = 11; $i < 19; $i++) {
                array_push($St,$details->startingAt[$i]);
                array_push($Et,$details->endingAt[$i]);
            }
            array_push($Date_Time,implode('',$Sd),implode('',$Ed),implode('',$St),implode('',$Et));
            $showButton = true;
            return view('events.show', compact('details','Date_Time','showButton'));
        } 
        
        else if ($request->isMethod('POST') && !is_null($request->input('eventTitle'))) //! Campaign Details Page (Page III)
        {
            $eventTitle = $request->input('eventTitle');
            $event = \App\Models\Event::all()->where('title', $eventTitle)->toArray();
            $event = array_reduce($event, 'array_merge', array()); // turning it into a simple 'one-layer' associative arr
            
            $Campaigns = Campaign::all()->where('eventId', $event['id']);
            

            $CampaignsCount = $Campaigns->count();

            $CampaignRelaunchesNumber = $Campaigns->where('status', 'Relanch')->count();
            $CampaignComplementsNumber = $Campaigns->where('status', 'Complement')->count();

            $viewData = true;
            $stop = false; //? view the campaignController@index (the else part)
            return view('Campaign.viewCampaign', compact('stop','viewData','event', 'Campaigns', 'CampaignsCount', 'CampaignRelaunchesNumber', 'CampaignComplementsNumber'));
        } 
        
        else //! Choose an Event Page (Page I)
        {
            $dt = Carbon::now('GMT+1')->format("Y-m-d H:i:s");
            $eventswithCamps= DB::select('SELECT E.* FROM events as E INNER JOIN campaigns as C on E.id = C.eventId order By E.id DESC');  //^ IDs of the events that actually have one or more campaigns 
            $allevents = DB::select('SELECT * from events order By id DESC'); //^ all the events
            $separator = ['Events with Campaigns'];
            $events =array_unique(array_merge($eventswithCamps, $separator, $allevents),SORT_REGULAR);

            
            
            $onGoingEvents = array();
            $endedEvents = array();
            foreach ($events as $event) 
            {
                if ($event == 'Events with Campaigns') {
                    array_push($onGoingEvents,$event);
                    array_push($endedEvents,$event);
                    continue;
                }
                $ending = $event->endingAt;
                
                if ($ending>$dt) 
                {
                    array_push($onGoingEvents,$event);
                }
                else if ($ending<=$dt)
                {
                    array_push($endedEvents,$event);
                }
            }
            $route = Route::current()->getName();
            $realtimedata = null;
            $Historydata = null;
            if ($route == 'realTimeData') 
            {
                $events = $this->paginate($request,$onGoingEvents);
                $realtimedata = true;
            }
            else if($route == 'history')
            {
                $events = $this->paginate($request,$endedEvents);
                $Historydata = true;
            }

            
            
             //dd($events[0]->title);
            return view('events.show', compact('events','realtimedata','Historydata'));
        }
    }

    public function paginate(Request $request, $items, $perPage = 10, $page = null, $options=[])
    {
        $page = isset($request->page) ? $request->page : 1; // Get the page=1 from the url
        /* $page = $page ?: (Paginator::resolveCurrentPage() ?: 1); */
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage), $items->count(), $perPage, $page,
            ['path' => $request->url()],
        );
    }
}
