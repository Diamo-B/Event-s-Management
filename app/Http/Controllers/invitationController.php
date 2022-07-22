<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class invitationController extends Controller
{
    public function create()
    {
        $participants = User::all();
        return view('invitation.create',compact('participants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required',
            'Body' => 'required',
        ]);

        $title = $request->input('Title');
        $body = $request->input('Body');

    }
}
