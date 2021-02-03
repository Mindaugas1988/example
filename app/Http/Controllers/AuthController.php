<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class AuthController extends Controller
{
    //


    public function showAuthForms(Request $response)
    {
        //


        return view('auth.auth');
    }


    public function verifyForms(){

        return view('auth.verify');

    }
}
