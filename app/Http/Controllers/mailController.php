<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\forgotPassMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function send(Request $request,$originalData,$data,$status,$invitation,$event,$Campaign)
    {
        $databaseParticiants = User::all()->where('roleId',3);
        $participantsEmails =  array();
        $ParticipantsData = array();
        foreach( $databaseParticiants as $user)
        {
            array_push( $ParticipantsData, $user);
            array_push( $participantsEmails, $user->email); 
        }

        $recipients = array();
        foreach ($data as $excel) 
        {
            if($status == 'Complement')
            {
                foreach($originalData as $PreexcelData)
                if ($excel == $PreexcelData) 
                {
                    continue;
                }
            }
            else
                array_push($recipients,$excel["email"]);
        }
        
         

        //^ $databaseParticiants holds the data of all present praticipants in the database (it has an indexing problem)
        //^ $ParticipantsData holds the data of the users with participant role in array form (index problem solved). use this
        //^ $participantsEmails holds the emails of the users with participant role
        //^ $data holds all the infos of the recipients
        //^ $recipients holds the emails of the recipients
        
        $role = Role::where('label','Participant')->get()[0];
        $userIndex=0;

        foreach ($recipients as $recipient ) 
        {
            $userIndex = array_search($recipient,array_column($data, 'email'));
            if (!(in_array($recipient,$participantsEmails))) 
            {
                
                $this->makeUser($request,$userIndex,$data,$role);
            }

            //* make relationship between the event and recipients
            $user =  User::where('email',$recipient)->get()[0];
            $hasLinkWithEvent = $user->events()->where('id', $event->id)->exists();
            if ($hasLinkWithEvent == false) 
            {
                $user->events()->attach($event);

                //*Create InviteToken
                $inviteToken = Str::random(40);
            
                DB::update('UPDATE event_user set inviteToken = ? where eventId = ? and userId = ?',[$inviteToken,$event->id,$user->id]);
            }
            else 
            {
                $arrayInviteToken = DB::select('SELECT inviteToken FROM event_user WHERE eventId = ? and userId= ?', [$event->id,$user->id]);
                $inviteToken = $arrayInviteToken[0]->inviteToken;
            }
            

            //* make the relationship between the campaign and the recipients
            $user->campaigns()->attach($Campaign);

            
            //* Send the data to the mailer function
            $az = Mail::to($recipient)->send(new \App\Mail\InvitationMail($data[$userIndex],$recipient,$status,$invitation,$event,$Campaign,$inviteToken));

        }

    }

    public function makeUser($request,$userIndex,$data,$role)
    {
        $newUser = new User(
            [
                'firstName' => $data[$userIndex]['firstName'],
                'lastName' => $data[$userIndex]['lastName'],
                'email' => $data[$userIndex]['email'],
                'password' =>Hash::make('password'),
            ]
        );   
        
        $newUser->role()->associate($role)->save();
        return;
    }

    public function sendForgetPass($email)
    {
        $resetToken = Str::random(60);
        User::where('email','=', $email)->update(array('forgetPassword_Token' => $resetToken));
        Mail::to($email)->send(new forgotPassMail($resetToken,$email));

    }
}