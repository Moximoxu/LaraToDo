<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraToDo\User;

class AdminController extends Controller
{
    protected function redirectTo() {
        return '/index';
    } 

    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function show(){
        $result = User::orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function edituserdetails(User $user){ 
    	$name = $user->name;
    	$email = $user->email;
    	$birthdate = $user->birthdate;
    	$roles = $user->roles;
    	return redirect('adminedituser')->with('name' , $name)->with('email' , $email)->with('birthdate' , $birthdate);
    }

    public function edituser(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'birthdate' => 'required',
            'roles' => 'required',
        ]);
        $useremail = $request->get('email');

        $user = User::where('email', $useremail);

        $user_data = array(
            'name' => $request->get('name'),
            'email' => $useremail,
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'updated_at' => Carbon::now(),
            'roles' => $request->get('roles'),
        );

        $user->fill($user_data);
        $user->save();

        return redirect('/admin');
    }

    public function destroy(User $user){
        $user->delete();
    }
}
