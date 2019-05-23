<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'delay', 'message'
    ];
}
