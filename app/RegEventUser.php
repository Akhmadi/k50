<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegEventUser extends Model
{
    //
    protected $table='reg_event_users';

    public function posts(){
        $this->belongsToMany(Post::class, 'reg_event_link_data', 'user_id', 'post_id');
    }
}
