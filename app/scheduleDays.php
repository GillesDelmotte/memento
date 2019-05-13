<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class scheduleDays extends Model
{
    protected $fillable = [
        'name', 'schedule_id', 'ms', 'me', 'as', 'ae', 'time'
    ];
}
