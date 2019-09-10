<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraToDo\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function show(){
        $result = User::where('roles', 'member')->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function edituser(Request $request){
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'gender' => 'required',
                'birthdate' => 'required',
        ]);
        $user = Auth::user();

        $user_data = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'gender' => $request->get('gender'),
            'birthdate' => $request->get('birthdate'),
            'updated_at' => Carbon::now(),
        );

        $user->fill($user_data);
        $user->save();

        return redirect('/admin/');
    }

    public function destroy(User $user){
        $user->delete();
    }
}
