<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id', 'type', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
