<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;
use Socialite;
use App\User;
class SocialController extends Controller
{
    //

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    private function get_countries_info($country_code){
        $path = url('json-resources/countries.json');
        $file = json_decode(file_get_contents($path), true);
        $collection = collect($file['countries']);
        $countries = $collection->firstWhere('iso', '==',Str::lower($country_code) );
        return $countries;
    }

    public function handleProviderCallback($provider)
    {
        $position = Location::get();
        $countries = $this->get_countries_info($position->countryCode);
        $getInfo = Socialite::driver($provider)->user();

        $email_exsists = User::where([
            ['email', '=', $getInfo->email],
            ['provider', '<>', null]])->first();

        $email_exsists2 = User::where([
            ['email', '=', $getInfo->email],
            ['provider', '<>', $provider]])->first();


        if ($email_exsists != null && $email_exsists2 != null) {
            return redirect()->route('error-page')->with('error',trans('custom.social_check'));
        }else{
            $user = $this->createUser($getInfo,$provider,$countries);
            Auth()->login($user);
            return redirect()->to('/');
        }

        // $user->token;
    }

    function createUser($getInfo,$provider, array $countries){

        $user = User::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'provider_id' => $getInfo->id,
        ],[
            'name'     => $getInfo->name,
            'email'    => $getInfo->email,
            'provider' => $provider,
            'avatar' => $getInfo->avatar,
            'provider_id' => $getInfo->id,
            'mobile_code'=> $countries['number_code'],
            'country_code'=> $countries['iso'],
            'flag_class'=> $countries['class'],
            'lt' => ['country' => $countries['lt']],
            'en' => ['country' => $countries['en']],
            'ru' => ['country' => $countries['ru']],
        ]);

        return $user;
    }
}
