<?php

namespace LaraToDo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LaraToDo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    function reset(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $user = Auth::user();

        $checkoldpsswrd = array(
            'email' => $request->get('email'),
            'password' => $request->get('oldpassword'),
        );

        $newpass = array(
            'password' => Hash::make($request->get('password')),
        );

        if(Auth::attempt($checkoldpsswrd)){
            $user->fill($newpass);
            $user->save();

            return redirect('login');
        }
        else{
            return  back()->with('error', 'Wrong old password');
        }
    }
}
