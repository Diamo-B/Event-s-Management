<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Generator\Method;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Session\Middleware\AuthenticatesSessions;

class NewPasswordController extends Controller
{
    public function create($token)
    { 
        return view('auth.newPassword',compact('token'));   
    }

    public function store(Request $request)
    {
        $token = $request->input('token');
        $oldPassword = $request->input('Old');
        $newPassword = $request->input('New');
        $passwordConfirmation = $request->input('Confirm');
        if(User::where('forgetPassword_Token','=',$token)->exists())
        {
            $user = User::where('forgetPassword_Token','=',$token)->get()->first()->getAttributes();
            
            if (Hash::check($oldPassword, $user['password']) ) 
            {
                if ($newPassword == $passwordConfirmation) 
                {
                    $newPassword = Hash::make($newPassword);
                    User::find($user['id'])->update(array('password'=>$newPassword));
                }
                else 
                {
                    return back()->withErrors('New password and password confirmation don\'t match');    
                }
            }
            else 
            {
                return back()->withErrors('Incorrect Old password. Please Retry'); 
            }
        }
        else 
        {
            return back()->withErrors('An unknown error has occured. Please try again');
        }
        Auth::loginUsingId($user['id'], TRUE);
        return redirect(route('dashboard'))->with('successMsg','Password changed successfully!');
    }
}
