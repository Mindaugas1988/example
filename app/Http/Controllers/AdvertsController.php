<?php

namespace App\Http\Controllers;

use App\Advert;
use Illuminate\Http\Request;

class Example
{
    var $country = null;
  	var $city = null;
  	var $email = 'm.virbickis88@gmail.com666';
    var $name = 'Vartotojas';
    var $number = '647151';
    var $country_code ='+358';

}

class AdvertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type,$id)
    {
        //
        return view('advert',compact('type','id'));
    }

    public function my_adverts(Advert $advert)
    {
        //
        return view('sign.my-adverts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function search_results()
    {
        //
        return view('search-results');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function show(Advert $advert)
    {
        //
        return view('sign.store-advert.new-advert');
    }

    public function new_car(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-car',compact('profile'));
    }

    public function new_motobike(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-motobike',compact('profile'));
    }

    public function new_truck(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-truck',compact('profile'));
    }

    public function new_under_truck(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-under-truck',compact('profile'));
    }

    public function new_semi(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-semi',compact('profile'));
    }

    public function new_autotrains(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-autotrains',compact('profile'));
    }

    public function new_buses(Advert $advert)
    {
        //
        $profile = new Example;
        return view('sign.store-advert.new-buses',compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function edit(Advert $advert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advert $advert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advert  $advert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advert $advert)
    {
        //
    }


}
