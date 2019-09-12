<?php

use Illuminate\Database\Seeder;
use LaraToDo\Task;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task = new Task();
	    $task->name = 'Learn more about Laravel';
	    $task->done = 0;
	    $task->user_id = 1;
	    $task->save();
	}
}
