<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Event;
use App\Models\Invitation;
use App\Http\Controllers\mailController;
use Illuminate\Http\Request;
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

        $events = Event::all()->whereIn('id', $eventsWithInvitation);

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
        $invitation = Invitation::all()->where('eventId',$eventId)[0];
        $relaunchNumber = 0;
        $countComplement = (Campaign::all()->where('status', 'Complement')->count());
        $count = Campaign::all()->where('invitationId', $invitation->id )->count();
        if ($status == 'Original') 
        {
            if ($count > 0)
                dd('error the invitation with the id ' . $invitation->id . ' already has an original Campaign');
            else
                goto makeCampaign;
        }
        if ($status == 'Relanch' || $status == 'Complement') 
        {
            if ($count == 0) 
            {
                dd('error the invitation with the id ' . $invitation->id  . ' needs to have an original Campaign before relaunches or complements');
                return;
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
        $mailController = new mailController;
        $mailController->send($request,$data,$status,$invitation,$event,$Campaign);
        
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
}
