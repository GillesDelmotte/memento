<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

use memento\Appointment;

class Todo extends Model
{
    protected $fillable = [
        'appointment_id', 'when'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}