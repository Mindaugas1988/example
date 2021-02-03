<?php

namespace App\Http\Controllers;

use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Stevebauman\Location\Facades\Location;

class Theme
{
    var $category = 'Specialistai atsakys į Jūsų klausimus';
  	var $subcategory = 'Padangos ir ratlankiai';
  	var $topic = 'Koks skirtumas';
    var $topic_content = 'Eik nx';

}

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function get_country_names($country_code){
        $path = url('json-resources/countries.json');
        $file = json_decode(file_get_contents($path), true);
        $collection = collect($file['countries']);
        $countries = $collection->firstWhere('iso', '==',Str::lower($country_code) );
        return $countries;
    }

    public function index()
    {

        //
        $position = Location::get();
        $countries = $this->get_country_names($position->countryCode);

        return view('forum',compact('countries'));
    }

    public function my_topics()
    {
        //
        return view('sign.my-topics');
    }

    public function categories()
    {
        //
        return view('forum-categories');
    }

    public function single()
    {
        //
        return view('forum-single');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $mumis = new Theme;
        return response()-> view('sign.topic-edit',compact('id','mumis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        //
    }
}
