<?php

namespace LaraToDo;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
	
	protected $primaryKey = 'id';

	protected $fillable = [
        'name', 'done',
    ];
};
