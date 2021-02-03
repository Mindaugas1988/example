<?php


namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;

class ManualRegisterController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    private function get_countries_info($country_code){
        $path = url('json-resources/countries.json');
        $file = json_decode(file_get_contents($path), true);
        $collection = collect($file['countries']);
        $countries = $collection->firstWhere('iso', '==',Str::lower($country_code) );
        return $countries;
    }

    protected function create(array $data, array $countries)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'flag_class'=> $countries['class'],
            'mobile_code'=> $countries['number_code'],
            'country_code'=> $countries['iso'],
            'lt' => ['country' => $countries['lt']],
            'en' => ['country' => $countries['en']],
            'ru' => ['country' => $countries['ru']],
        ]);
        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function register(Request $request)
    {
        $position = Location::get();
        $countries = $this->get_countries_info($position->countryCode);
        $rules = array(
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'accepted' =>['accepted']
        );
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $this->create($request->all(), $countries);
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return response()->json([
            'message' => 'Success',
            'status'=> true
        ], 200);
    }

}


