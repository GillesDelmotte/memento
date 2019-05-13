<?php

namespace memento\Http\Controllers;

use memento\Profile;
use memento\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['route' => 'profile']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \memento\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \memento\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \memento\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile, User $user)
    {
        $user = $user->where('id', auth()->id())->first();
        $column = $request['column'];
        $value = $request['value'];
        $input = $request['input'];


        if($input === 'text'){
            $user->$column = $value;
        }else if($input === 'check'){
            if($value === 'false'){
                $user->$column = false;
            }else {
                $user->$column = true;
            }
        }

        

        $user->save();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \memento\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
