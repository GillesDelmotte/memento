<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    public function days(){
        return $this->hasMany(ScheduleDays::class);
    }
}
