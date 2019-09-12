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
    protected function redirectTo() {
        return '/index';
    } 
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

        $useremail = $request->get('email');
        $userpassword = $request->get('password');

        if(Auth::attempt(['email' => $useremail, 'password' => $userpassword, 'roles' => 'admin'])){
            return redirect('/admin');
        }
        elseif(Auth::attempt(['email' => $useremail, 'password' => $userpassword, 'roles' => 'member'])){
            return redirect('/index');
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
