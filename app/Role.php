<?php

namespace LaraToDo;

use Illuminate\Database\Eloquent\Model;
use LaraToDo\User;

class Role extends Model
{
    public function users(){
	  return $this->belongsToMany(User::class);
	}
}
