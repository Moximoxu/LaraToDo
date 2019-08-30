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
    function edituser(Request $request){
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'gender' => 'required',
                'birthdate' => 'required',
                'password' => 'required|min:5',
        ]);
        $user = Auth::user();

        $user_data = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'password' => Hash::make($request->get('password')),
            'updated_at' => Carbon::now(),
        );

        $user->fill($user_data);
        $user->save();

        return redirect('/index');
    }
}
