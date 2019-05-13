<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'schedule_id', 'hour', 'date'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
