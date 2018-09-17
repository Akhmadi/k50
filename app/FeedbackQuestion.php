<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'text' ];
}
