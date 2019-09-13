<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaraToDo\Http\Controllers\Controller;
use LaraToDo\User;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    public function show(){
        $result = User::orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function edituserdetails(User $user){ 
    	$userid = $user->id;
    	$name = $user->name;
    	$email = $user->email;
    	$birthdate = $user->birthdate;
    	$roles = $user->roles;
    	return redirect('adminedituser')->with('name' , $name)->with('email' , $email)->with('birthdate' , $birthdate)->with('roles' , $roles);
    }

    public function edituser(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'birthdate' => 'required',
            'roles' => 'required',
        ]);

        DB::table('users')->updateOrInsert(
        	['email' => $request->get('email')],
            ['name' => $request->get('name'),
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'updated_at' => Carbon::now(),
            'roles' => $request->get('roles')]
        );

        return redirect('/admin');
    }

    public function destroy(User $user){
        $user->delete();
    }
}
