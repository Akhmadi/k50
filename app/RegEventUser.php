<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegEventUser extends Model
{
    //
    protected $table='reg_event_users';
    protected $guarded = array('id');

    public function posts(){
        return $this->belongsToMany(Post::class, 'reg_event_link_data', 'user_id', 'post_id')
            ->withPivot(['meta']);
    }
}
