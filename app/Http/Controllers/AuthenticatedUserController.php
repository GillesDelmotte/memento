<?php

namespace memento\Http\Controllers;

use Illuminate\Http\Request;
use memento\FilesUpload;

class AuthenticatedUserController extends Controller
{
    public function fetch(){
        $user = auth()->user();

        $image = FilesUpload::where('user_id', auth()->id())->first();

        return ['user' => $user->load('job'), 'img' => $image];
    }
}
