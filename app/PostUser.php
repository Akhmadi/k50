<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostUser extends Model
{
    protected $table = 'posts_users';

    function post(){
    	return $this->belongsTo(Post::class);
    }

	function user(){
		return $this->belongsTo(User::class);
	}
}
