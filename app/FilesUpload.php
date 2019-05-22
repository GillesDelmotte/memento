<?php

namespace memento;

use Illuminate\Database\Eloquent\Model;

class FilesUpload extends Model
{
    protected $fillable = [
        'user_id', 'image_name'
    ];
}
