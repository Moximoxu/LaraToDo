<?php

namespace LaraToDo\Http\Controllers\Auth;

use LaraToDo\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraToDo\User;
use Validator; 

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/index';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function index(){
        return view('/index');
    }

    function checklogin(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);

        $user_data = array(
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($user_data)){
            if (Auth::user() == User::where('roles', 'admin')){
                return redirect('/admin');
            }
            elseif(Auth::user() == User::where('roles', 'user')){
                return redirect('/index');
            }
        }
        else{
            return  back()->with('error', 'Wrong login details');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
