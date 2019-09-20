<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use LaraToDo\User;
use LaraToDo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EditProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    function edituser(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'birthdate' => 'required',
        ]);
        $user = Auth::user();

        $useremail = $request->get('email');

        $user_data = array(
            'name' => $request->get('name'),
            'email' => $useremail,
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'updated_at' => Carbon::now(),
        );

        $user->fill($user_data);
        $user->save();

        if(User::Where(['email' => $useremail, 'roles' => 'admin'])){
            return redirect('/admin');
        }
        elseif(User::Where(['email' => $useremail, 'roles' => 'member'])){
            return redirect('/index');
        }
    }

    function checkRole(User $user){
        if(User::Where(['email' => $user->email, 'roles' => 'admin'])){
            return redirect('/admin');
        }
        elseif(User::Where(['email' => $user->email, 'roles' => 'member'])){
            return redirect('/index');
        }
    }
}