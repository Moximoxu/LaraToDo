<?php

namespace LaraToDo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaraToDo\Task;

class TaskController extends Controller
{

    public function fetchtasks(){
        $userid = Auth::id();
        $result = Task::where('user_id', $userid)->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public function create(){
        return view('task.create');
    }

    public function createTask(){
        $userid = Auth::id();
        $task = new Task();
        $task->user_id = $userid;
        $task->name = request('name');
        $task->save();
        return $task;
    }

    public function deleteTask(){
        $taskid = request('id');
        $delete = Task::findOrFail($taskid);
        $delete->delete();
    }

    public function updateTask(){
        $taskid = request('id');
        $taskname = request('name');
        $updatetask = Task::where('id',$taskid);
        $updatetask->update(['name' => $taskname]);
    }

    public function doneTask(){
        $taskid = request('id');
        $donetask = Task::where('id',$taskid);
        $donetask->update(['done' => 1]);
    }

    public function undoneTask(){
        $taskid = request('id');
        $undonetask = Task::where('id',$taskid);
        $undonetask->update(['done' => 0]);
    }

    public function destroy(Task $task){
        $task->delete();
    }
}
