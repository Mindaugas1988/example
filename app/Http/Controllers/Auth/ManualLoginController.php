<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManualLoginController extends Controller
{
    //

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = array(
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        );
        $validator = Validator::make($credentials,$rules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
           }

        if (Auth::attempt($credentials, $request->remember)) {
            // Authentication passed...
            return response()->json([
                'message' => 'Success',
                'status'=> true
            ], 200);
        }

        return response()->json([
            'errors' => ['password'=>trans('validation.password')],
            'status' => false
        ]);





    }
}
