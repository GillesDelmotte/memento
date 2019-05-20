<?php

namespace memento\Http\Controllers;

use memento\Schedule;
use memento\ScheduleDays;
use memento\Appointment;
use memento\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Schedule $schedule)
    {
        $schedules = $schedule->where('user_id', auth()->id())->get();


        return $schedules->load('days');
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
        $name = $request['name']; 
        $days = $request['days'];
        $user = auth()->id();


        $schedule = Schedule::create(['name' => $name, 'user_id' => $user]);

        foreach($days as $day){

            ScheduleDays::create(['name' => $day['name'], 'schedule_id' => $schedule->id, 'ms' => $day['ms'], 'me' => $day['me'], 'as' => $day['as'], 'ae' => $day['ae'], 'time' => $day['time']]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \memento\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule, Request $request)
    {

        $schedules = $schedule->where('user_id', $request['id'])->first();

        if(empty($schedules)){
            return [];
        }else{
            return $schedules->load('days');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \memento\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \memento\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \memento\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule, Request $request)
    {
        $id = $request['id'];
        $schedule = Schedule::where('id', $id)->first();
        $scheduleDays = ScheduleDays::where('schedule_id', $id)->get();
        foreach($scheduleDays as $days){
            $days->delete();
        }
        $schedule->delete();
    }

    public function getClients(Request $request, Appointment $appointment, User $user)
    {
        $clients = [];
        $clients_id = Appointment::where('schedule_id', $request['id'])->distinct()->get('user_id');

        foreach($clients_id as $client_id){
            $user = User::select('id', 'name')->where('id', $client_id['user_id'])->first();
            $clients[] = $user; 
        }

        return $clients;
    }

    public function sendEmail(Request $request)
    {
        if($request['type'] === 'add'){
            return 'add';
        }
        if($request['type'] === 'remove'){
            return 'remove';
        }
    }
}
