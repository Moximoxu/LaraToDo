<?php

namespace LaraToDo;

use Illuminate\Database\Eloquent\Model;

class Summernote extends Model
{
    protected $table = 'summernotes';
	
	protected $primaryKey = 'id';

	protected $fillable = [
        'content', 'created_at', 'updated_at',
    ];
}
