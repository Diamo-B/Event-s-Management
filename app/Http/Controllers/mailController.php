<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class mailController extends Controller
{
    public function send(Request $request,$data,$status,$invitation,$event,$Campaign)
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
                
                $this->makeUser($userIndex,$data,$role);
            }

            //* make relationship between the event and recipients
            $user =  User::where('email',$recipient)->get()[0];
            $user->events()->attach($event);

            //* make the relationship between the campaign and the recipients
            $user->campaigns()->attach($Campaign);

            //* Send the data to the mailer function
            Mail::to($recipient)->send(new \App\Mail\InvitationMail($data[$userIndex],$recipient,$status,$invitation,$event,$Campaign));
            sleep(2);
        }
       
    }

    public function makeUser($userIndex,$data,$role)
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
}