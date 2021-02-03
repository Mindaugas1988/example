<?php


namespace App\Http\Controllers;
use App\User;
use App\Events\AvatarUpdateStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;


class ProfileController extends Controller
{
    //

    private function get_country_names($country_code){
        $path = url('json-resources/countries.json');
        $file = json_decode(file_get_contents($path), true);
        $collection = collect($file['countries']);
        $countries = $collection->firstWhere('iso', '==',Str::lower($country_code) );
        return $countries;
    }

    public function show_profile()
    {
        //
        return view('sign.profile');
    }

    public function update_profile(Request $request)
    {
        //
        $countries = $this->get_country_names($request->data['country_code']);
        $rules = array(
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth()->user()->id.',id',
            'new_pass' => ['nullable','string', 'min:8'],
            'repeat_pass' =>['same:new_pass'],
            'name'=>['required','string','max:100'],
            'city'=> ['nullable','string', 'max:255'],
            'country_code'=> ['required','string','max:2'],
            'mobile_code' => ['required','string','max:4'],
            'number' => ['nullable','numeric','min:6'],
            'current_flag'=>['required','string','max:20'],

        );
        $validator = Validator::make($request->data,$rules);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }


        $user = User::find(Auth::id());
        $user->email = $request->data['email'];
        $user->name = $request->data['name'];
        if ($request->data['new_pass'] != null){
            $user->password = Hash::make($request->data['new_pass']);
        }
        $user->mobile_code = $request->data['mobile_code'];
        $user->city = $request->data['city'];
        $user->flag_class = $request->data['current_flag'];
        $user->country_code = $request->data['country_code'];
        $user->mobile = $request->data['number'];
        $user->translate('lt')->country = $countries['lt'];
        $user->translate('en')->country = $countries['en'];
        $user->translate('ru')->country = $countries['ru'];

        $user->save();

        return response()->json([
            'message' => trans('custom.success_update'),
            'status'=> true
        ], 200);


    }

    public function  update_avatar(Request $request){

        $validator = Validator::make($request->all(), [
            'avatar' => 'image|mimes:jpeg,jpg,png|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        $photo = $request->file('avatar');
        $filename = Storage::disk('public')->put('images/avatars', $photo);
        $user = User::find(Auth::id());
        Storage::disk('public')->delete($user->avatar);
        $user->avatar = $filename;
        $user->save();
        $avatar = asset(Storage::url($user->avatar));
        AvatarUpdateStatus::dispatch($avatar);
        return response()->json([
            'message' => trans('custom.success_update'),
            'status'=> true
        ]);


    }

    public function get_avatar(){
        $user = User::find(Auth::id());
        if(Str::is('images/avatars/*', $user->avatar)) {
            $avatar = asset(Storage::url($user->avatar));
        }
        else if(Str::is('https://graph.facebook.com/*', $user->avatar) || Str::is('
         https://lh3.googleusercontent.com/*', $user->avatar)){
            $avatar = $user->avatar;
        }
        else if(Str::is('https://lh3.googleusercontent.com/*', $user->avatar)){
            $avatar = $user->avatar;
        }
        else{
            $avatar = null;
        }

        return $avatar;
    }

    public function delete_user(){
        $user = User::find(Auth::id());
        Storage::disk('public')->delete($user->avatar);
        $user->delete();
        return redirect()->to('/');
    }

}
