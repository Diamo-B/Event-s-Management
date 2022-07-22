<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class mailController extends Controller
{
    public function send()
    {
        $details = [
            "title" => "Invitation to the event 5",
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. A iaculis at erat pellentesque. Urna nec tincidunt praesent semper feugiat nibh sed. Bibendum est ultricies integer quis auctor. Nibh tellus molestie nunc non blandit. Vitae auctor eu augue ut lectus. Ullamcorper malesuada proin libero nunc consequat interdum varius sit. Posuere urna nec tincidunt praesent semper. Natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Dui vivamus arcu felis bibendum ut tristique et egestas. Ipsum nunc aliquet bibendum enim facilisis gravida neque.',
        ];
        $users = ['user1@gmail.com','user2@gmail.com','user3@gmail.com','user4@gmail.com'];
        Mail::to($users)->send(new \App\Mail\InvitationMail($details));
        dd('email is sent');
    }
}
