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
            return back()->withErrors('Aucun utilisateur avec cet email n\'a été trouvé dans notre base de données');
        }
        else 
        {
            $mailController = new mailController;
            $mailController->sendForgetPass($email);
            return redirect(route('login'))->with(['successMsg'=>'L\'e-mail a été envoyé avec succès!']);
        }
    }
}
