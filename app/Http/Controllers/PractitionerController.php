<?php

namespace memento\Http\Controllers;

use memento\Practitioner;
use memento\User;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $user = User::Where('schedule', '=', 1)->where('id', '<>', auth()->id())->orderBy('name', 'asc')->get();
        return $user->load('job');
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
     * @param  \memento\Practitioner  $practitioner
     * @return \Illuminate\Http\Response
     */
    public function show(Practitioner $practitioner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \memento\Practitioner  $practitioner
     * @return \Illuminate\Http\Response
     */
    public function edit(Practitioner $practitioner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \memento\Practitioner  $practitioner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practitioner $practitioner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \memento\Practitioner  $practitioner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practitioner $practitioner)
    {
        //
    }
}
