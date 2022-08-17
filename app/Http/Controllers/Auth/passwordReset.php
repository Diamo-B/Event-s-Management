<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\mailController;

class passwordReset extends Controller
{
    public function create()
    {
        return view('auth.forgotPassword');
    }

    public function store(Request $request)
    {
        $email = $request->input('email');
        $checkMail = User::where('email', '=', $email)->exists()?true:false;
        if ($checkMail == false)
        {
            return back()->withErrors('no user with that email was found in our database');
        }
        else 
        {
            $mailController = new mailController;
            $mailController->sendForgetPass($email);
            return redirect(route('login'))->with(['successMsg'=>'Email was sent successfully!']);
        }
    }
}
