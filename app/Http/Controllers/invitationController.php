<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Asika\pdf2text;

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
            'attachment' => 'required|file|mimes:txt,docx,pdf',
        ]);
        $eventID = $request->input('Event');
        $event = Event::find($eventID);
        $body = $request->input('Body'); 

        //- Getting the attachment file and stores it's text in a content variable
        $file = $request->file('attachment');
        $fileExtention = $file->getClientOriginalExtension();
        switch ($fileExtention) {
            case 'txt':
                $content = str_replace(['\n','\r'],' ',file_get_contents($file->getRealPath()));                
                break;
            case 'docx':
                $content = $this->docx_to_text($file->getRealPath());
                break;
            case 'pdf':
                $reader = new Pdf2text();
                $content = $reader->decode($file->getRealPath());
                break;
            default:
                dd('file extension Non Supported');
                break;
        }
        $invitation = new Invitation(
            [
                'eventId' => $eventID,
                'object' => $body,
                'attachment' => $content
            ]
        );
        $invitation->save();
        $invitation->event()->associate($event)->save();
        return redirect(route('campaign.create',compact('event')));
    }
    
    
/**
 * Class RD_Text_Extraction
 *
 * Example usage:
 *
 * $response = RD_Text_Extraction::convert_to_text($path_to_valid_file);
 *
 * For PDF text extraction, this class requires the Smalot\PdfParser\Parser class.
 * @see https://stackoverflow.com/questions/19503653/how-to-extract-text-from-word-file-doc-docx-xlsx-pptx-php
 *
 */

    protected static function docx_to_text( $path_to_file )
    {
        $response = '';
        $zip      = zip_open($path_to_file);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE)
                continue;

            if (zip_entry_name($zip_entry) != 'word/document.xml')
                continue;

            $response .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }

        zip_close($zip);

        $response = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $response);
        $response = str_replace('</w:r></w:p>', "\r\n", $response);
        $response = strip_tags($response);

        return $response;
    }


}
   
