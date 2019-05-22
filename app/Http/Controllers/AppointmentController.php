<?php

namespace memento\Http\Controllers;

use memento\Appointment;
use memento\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appointments = Appointment::where('schedule_id', $request['id'])->orderBy('date', 'asc')->get();

        if($request['client'] === true){
            return $appointments->load('client');
        }else{
            return $appointments;
        }

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
    public function store(Appointment $appointment, Todo $todo, Request $request)
    {
        $user_id = $request['user_id'];
        $schedule_id = $request['schedule_id'];
        $hour = $request['hour'];
        $date = $request['date'];

        $appointment = Appointment::create(['user_id' => $user_id, 'schedule_id' => $schedule_id, 'hour' => $hour, 'date' => $date]);

        $when = date('Y-m-d', strtotime('-1 day', strtotime($date)));

        //creer le message a envoyer

        Todo::create(['appointment_id' => $appointment['id'], 'when' => $when ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \memento\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \memento\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \memento\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \memento\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment, Request $request)
    {
        $schedule_id = $request['schedule_id'];
        $hour = $request['hour'];
        $date = $request['date'];
        $appointment = Appointment::where('schedule_id', $schedule_id)->where('hour', $hour)->where('date', $date)->first();
        $appointment->delete();
    }

    public function myAppointments(Appointment $appointment)
    {
        //$myAppointments = Appointment::whereRaw('user_id =' . auth()->id() . "' and DATE_FORMAT(date, "%Y%m%d") > DATE_FORMAT(NOW(), "%Y%m%d")')->orderBy('date', 'asc')->get();
        //$myAppointments = Appointment::where('user_id', Auth()->id())->where('date', '>=', Carbon::now())->orderBy('date', 'asc')->get();
        $myAppointments = Appointment::where('user_id', Auth()->id())->whereDate('date', '>=', Carbon::now())->orderBy('date', 'asc')->get();


         return $myAppointments->load('schedule');
    }
}
