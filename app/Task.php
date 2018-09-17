<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    function company(){
    	return $this->belongsTo(Company::class);
    }
}
