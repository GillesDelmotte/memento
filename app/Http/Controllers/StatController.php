<?php

namespace memento\Http\Controllers;

use memento\Stat;
use memento\User;
use memento\Schedule;
use memento\Appointment;
use memento\Job;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userNumber = User::count();
        $scheduleNumber = Schedule::count();
        $appointmentNumber = Appointment::count();
        $JobNumber = Job::count();

        return ['user' => $userNumber, 'schedule' => $scheduleNumber, 'appointment' => $appointmentNumber, 'job' => $JobNumber];
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
     * @param  \memento\Stat  $stat
     * @return \Illuminate\Http\Response
     */
    public function show(Stat $stat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \memento\Stat  $stat
     * @return \Illuminate\Http\Response
     */
    public function edit(Stat $stat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \memento\Stat  $stat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stat $stat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \memento\Stat  $stat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stat $stat)
    {
        //
    }
}
