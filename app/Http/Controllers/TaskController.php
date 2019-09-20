<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraToDo\Task;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'verified']);
    }

    protected function redirectTo() {
        return '/login';
    } 

    public function show(){
        $userid = Auth::id();
        $result = Task::where('user_id', $userid)->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function store(){
        $userid = Auth::id();
        $task = new Task();
        $task->user_id = $userid;
        $task->name = request('name');
        $task->save();
        return $task;
    }

    public function update(){
        $taskid = request('id');
        $taskname = request('name');
        $updatetask = Task::where('id',$taskid);
        $updatetask->update(['name' => $taskname]);
    }

    public function done(Task $task){
        $task->update(['done' => 1]);
    }

    public function undone(Task $task){
        $task->update(['done' => 0]);
    }

    public function destroy(Task $task){
        $task->delete();
    }
}
