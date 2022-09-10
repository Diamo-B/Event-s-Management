<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class NewPasswordController extends Controller
{
    public function create($token)
    { 
        return view('auth.newPassword',compact('token'));   
    }

    public function store(Request $request)
    {
        $token = $request->input('token');
        $newPassword = $request->input('New');
        $passwordConfirmation = $request->input('Confirm');
        if(User::where('forgetPassword_Token','=',$token)->exists())
        {
            $user = User::where('forgetPassword_Token','=',$token)->get()->first()->getAttributes();
            if ($newPassword == $passwordConfirmation) 
            {
                $newPassword = Hash::make($newPassword);
                User::find($user['id'])->update(array('password'=>$newPassword));
            }
            else 
            {
                return back()->withErrors('Le nouveau mot de passe et la confirmation du mot de passe ne correspondent pas');    
            }
        }
        else 
        {
            return back()->withErrors('Une erreur inconnue s\'est produite. Veuillez réessayer');
        }
        Auth::loginUsingId($user['id'], TRUE);
        return redirect(route('dashboard'))->with('successMsg','Le mot de passe a été changé avec succès!');
    }
}
