<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $userRole = auth()->user()->roleId;
        return view('dashboard',['role'=>$userRole]);
    }
}
