<?php

namespace LaraToDo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LaraToDo\User;
use LaraToDo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;

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

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    function reset(Request $request){
        $this->validate($request, [
            'password' => 'required|min:5',
        ]);

        $user = Auth::user();

        $user_data = array(
            'password' => Hash::make($request->get('password')),
        );

        $user->fill($user_data);
        $user->save();

        return redirect('login');
    }
}
