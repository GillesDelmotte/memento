<?php

namespace memento\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedUserController extends Controller
{
    public function fetch(){
        $user = auth()->user();

        return $user->load('job');
    }
}
