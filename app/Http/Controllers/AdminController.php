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

    protected function redirectTo() {
        return '/login';
    } 

    public function show(){
        $users = DB::table('users')->simplePaginate(10);
        return view('admin', ['users' => $users]);
    }

    public function showSearch(Request $request){
        $q = $request->get ( 'q' );
        $users = DB::table('users')->where('name','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->simplePaginate(10);
        if($q == 'members' OR $q == 'member'){
            $users = DB::table('users')->where('roles','LIKE','%'.$q.'%')->simplePaginate(10);
            if(count($users) > 0)
                return view('admin', ['users' => $users]);
            else 
                return view ('admin', ['message' => "No $q users found."]);
        }
        elseif($q == 'admin' OR $q == 'admins'){
            $users = DB::table('users')->where('roles','LIKE','%'.$q.'%')->simplePaginate(10);
            if(count($users) > 0)
                return view('admin', ['users' => $users]);
            else 
                return view ('admin', ['message' => "No $q users found."]);
        }
        elseif($q == 'male'){
            $users = DB::table('users')->where('gender','LIKE','%'.$q.'%')->simplePaginate(10);
            if(count($users) > 0)
                return view('admin', ['users' => $users]);
            else 
                return view ('admin', ['message' => "No $q users found."]);
        }
        elseif($q == 'female'){
            $users = DB::table('users')->where('gender','LIKE','%'.$q.'%')->simplePaginate(10);
            if(count($users) > 0)
                return view('admin', ['users' => $users]);
            else 
                return view ('admin', ['message' => "No $q users found."]);
        }
        else{
            if(count($users) > 0)
                return view('admin', ['users' => $users]);
            else 
                return view ('admin');
        }
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
