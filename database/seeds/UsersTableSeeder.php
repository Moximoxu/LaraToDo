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
        
        $role_member = Role::where('name', 'member')->first();
        $role_admin  = Role::where('name', 'admin')->first();
        
        $member = new User();
        $member->name = 'Member Name';
        $member->email = 'employee@example.com';
        $member->password = Hash::make('secret');
        $member->roles()->attach($role_member);
        $member->save();
        
        $admin = new User();
        $admin->name = 'Admin Name';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('secret');
        $admin->roles()->attach($role_admin);
        $admin->save();
    }
}
