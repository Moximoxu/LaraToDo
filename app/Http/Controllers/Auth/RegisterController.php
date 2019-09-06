<?php

namespace LaraToDo\Http\Controllers\Auth;

use LaraToDo\User;
use LaraToDo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegisterController extends Controller
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \LaraToDo\User
     */
    function create(Request $request){
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'gender' => 'required',
                'birthdate' => 'required',
                'password' => 'required|min:5',
        ]);

        $email_u = $request->get('email');

        $user_data = array(
            'name' => $request->get('name'),
            'email' => $email_u,
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'password' => Hash::make($request->get('password')),
            'remember_token' => random_bytes(10),
            'created_at' => Carbon::now(),
        );

        User::insert($user_data);

        $user = User::where('email', $email_u)->first();

        $user->sendEmailVerificationNotification();

        return redirect('verify');
    }
}