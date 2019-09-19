<?php

use Illuminate\Database\Seeder;
use LaraToDo\User;
use LaraToDo\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i=0; $i < 30; $i++){
           $member = new User();
            $member->name = "Member Name$i";
            $member->email = "employee$i@example.com";
            $member->password = Hash::make('password');
            $member->roles = 'member';
            $member->save(); 
        }
        
    }
}
