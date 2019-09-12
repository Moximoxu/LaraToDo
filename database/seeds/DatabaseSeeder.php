<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call('UsersTableSeeder');
        // Role comes before User seeder here.
        $this->call('RoleTableSeeder');
        $this->call('TaskTableSeeder');
    }
}
