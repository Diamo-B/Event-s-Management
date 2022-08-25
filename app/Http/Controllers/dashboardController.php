<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class dashboardController extends Controller
{
    public function index()
    {
        $userRole = auth()->user()->roleId;
        return view('dashboard',['role'=>$userRole]);
    }

    public function settings(Request $request)
    {
        if ($request->isMethod('POST')) 
        {
            if ($request->submit == 'save') 
            {
                
                $user = User::find(Auth::user()->id);
                $fname = $request->input('Fname');
                $lname = $request->input('Lname'); 
                $language = $request->input('Lang');
                if (Auth::user()->firstName !== $fname && $fname !== null) 
                {
                    $user->update(['firstName'=>$fname]);
                }
                if (Auth::user()->lastName !== $lname && $lname !== null)
                {
                    $user->update(['lastName'=>$lname]);
                }
                if(app()->getLocale() !== $language )
                {
                    app()->setLocale($language);
                }
                return back();//Redirect::route('dashboard');
            }
            if ($request->submit == 'changePass') 
            {
                dd('password');
            }
        }
        else
            return view('Settings');
    }
}
