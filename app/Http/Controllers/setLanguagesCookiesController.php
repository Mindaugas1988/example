<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
class setLanguagesCookiesController extends Controller
{
    //
    public function index($lang)
    {
        $time = 3600*24*365;
        Cookie::queue('language',$lang, $time);
        return back();
    }
}
