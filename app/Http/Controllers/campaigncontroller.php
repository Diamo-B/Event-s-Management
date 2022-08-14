<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\Invitation;
use App\Http\Controllers\mailController;
use App\Models\invitationConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class campaigncontroller extends Controller
{
    public function create()
    {
        //! this piece of code searches for all the events that have an invitation and returns them to the 'Campaign Creation' view
        $invitations = Invitation::all();
        $eventsWithInvitation = array();
        foreach ($invitations as $invitation) {
            array_push($eventsWithInvitation, $invitation->eventId);
        }
        $eventsWithInvitation = array_values(array_unique($eventsWithInvitation));

        $events = Event::all()->whereIn('id', $eventsWithInvitation)->where('startingAt','>',Carbon:: now('GMT+1'));

        return view('Campaign.Create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'event' => 'required',
                'status' => 'required|in:Original,Relanch,Complement',
                'participants' => 'required|file|mimes:xlsx,xls'
            ]
        );
        $eventId = $request->input('event');
        $event = Event::find($eventId);
        $status = $request->input('status');
        $invitation = Invitation::where('eventId',$eventId)->get()[0];
        $relaunchNumber = 0;
        $countComplement = (Campaign::all()->where('status', 'Complement')->count());
        $count = Campaign::all()->where('invitationId', $invitation->id )->count();
        if ($status == 'Original') 
        {
            if ($count > 0)
                return back()->withErrors(['The invitation of the event ' . $event->title . ' already has an original Campaign']);
            else
                goto makeCampaign;
        }
        if ($status == 'Relanch' || $status == 'Complement') 
        {
            if ($count == 0) 
            {
                return back()->withErrors(['The invitation of the event ' . $event->title . ' needs to have an original Campaign before relaunches or complements']);
            }
            if ($status == 'Relanch') 
            {
                $relaunchNumber = $count - $countComplement;
            }
            if ($status == 'Complement')
                $countComplement++;
            $relaunchNumber = $count - $countComplement;
        }
        makeCampaign:
        $Campaign = new Campaign(
            [
                'status' => $status,
                'relaunchNumber' => $relaunchNumber,
            ]
        );
        $Campaign->Invitation()->associate($invitation);
        $Campaign->event()->associate($event)->save();

        $file = $request->file('participants');
        $data = $this->importData($file);
        $originalData = $data;
        $mailController = new mailController;
        $mailController->send($request,$originalData,$data,$status,$invitation,$event,$Campaign);

        Session::flash('successMsg','Campaign created and emails were sent successfully.'); 
        return redirect(route('dashboard'));
    }

    function importData($file)
    {
        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('F', $column_limit);
            $startcount = 2;
            $data = array();
            foreach ($row_range as $row) {
                $data[] = [
                    'title' => $sheet->getCell('A' . $row)->getValue(),
                    'firstName' => $sheet->getCell('B' . $row)->getValue(),
                    'lastName' => $sheet->getCell('C' . $row)->getValue(),
                    'email' => $sheet->getCell('D' . $row)->getValue(),
                ];
                $startcount++;
            }
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return  $error_code;
        }
        return $data;
    }

    public function index(Request $request)
    {
        //- First check if the form is submited
        if ($request->input('Events') == null) 
        {
            //^ If not: We are taking only the events that already have a Campaign by following these steps:

            //=> First fetch all the Campaigns
            $Campaigns = Campaign::all();

            //=> second create an array to hold the id of the events that already have a campaign
            $eventsWithCampaigns = array();

            //=> next, loop over all the campaigns and store each campaign's eventId in the eventsWithInvitation array
            foreach ($Campaigns as $Campaign) {
                array_push($eventsWithCampaigns, $Campaign->eventId);
            }
            
            //=> finally we fetch all the events that the $eventsWithInvitation array contain their Id
            
            $events = Event::all()->whereIn('id', $eventsWithCampaigns)->where('startingAt','>',Carbon:: now('GMT+1'));
            $Camp = true;
            return view('ChooseEvent',compact('events','Camp'));

        } else 
        {
            //^ If the form was submited: We need to show the Campaigns, the relaunch number if it was a relaunch or a complement 
            
            $eventId = $request->input('Events');
            $event = \App\Models\Event::all()->find($eventId)->toArray();

            $Campaigns = Campaign::all()->where('eventId',$eventId);
            $CampaignsCount = $Campaigns->count();
            $CampaignRelaunchesNumber = $Campaigns->where('status','Relanch')->count();
            $CampaignComplementsNumber = $Campaigns->where('status','Complement')->count();

            $userIds = array();
            foreach ($Campaigns as $Camp ) 
            {
                array_push($userIds, DB::select('select * from invitation_confirmations where eventId = ? and isConfirmed = 1 and isPresent = 0',[$eventId]));    
            }
            
            if (!array_filter($userIds)) 
            {
                $stop = true;
            }
            else
            {
                $stop = false;
            }
            
            return view('Campaign.viewCampaign',compact('event','Campaigns','CampaignsCount','CampaignRelaunchesNumber','CampaignComplementsNumber', 'stop'));
  
        }
        
    }

    public function presenceConfirm(Request $request,$eventId,$campaigns=null)
    {
        $presentUserIds = $request->input('presentUserIds');
        
        if (isset($presentUserIds)==false) 
        {

            $Campaigns = json_decode($campaigns);
            
            //=> get all the ids of every users who belongs to every campaign then store everything into an array
            $userIds = array();
            foreach ($Campaigns as $Campaign) 
            {
                $userId = DB::select('select userId from campaign_user where campaignId = ?',[$Campaign->id]);
                
                foreach ($userId as $id ) {
                    array_push($userIds,$id->userId);
                }
                
            }
            $userIds = array_unique($userIds); //=> remove duplicates

            //=> fetch all the infos of the users who accepted their invites
            $users = array();
            foreach ($userIds as $id) 
            {
                $acceptedUser = DB::select('select * from invitation_confirmations where userId = ? and eventId = ? and isConfirmed = 1 and isPresent = 0',[$id,$eventId]);
                
                if ($acceptedUser != null) 
                {
                    $user = User::find($id)->toArray();
                    array_push($users,$user); 
                }
            }
            return view('Campaign.viewCampaign', compact('users','eventId'));
        }
        else 
        {
            //=>Find all the 'invitationConfirmation' ids where eventId and usersId matches what we have
            foreach ($presentUserIds as $id )
            {
                invitationConfirmation::where('eventId',$eventId)->Where('userId',$id)->update(['isPresent'=>true]); 
            }
            return redirect(route('dashboard'));
        }
    }
}
