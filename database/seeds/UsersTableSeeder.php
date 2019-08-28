<?php

use Illuminate\Database\Seeder;
use LaraToDo\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
        	'name' => 'Supar bin Man',
        	'email' => 'supar.man@gmail.com',
        	'password' => Hash::make('password'),
        	'remember_token' => str_random(10),
        ]);
    }
}
