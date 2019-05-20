<?php

namespace memento\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use memento\User;
use memento\Schedule;
use memento\Todo;

use Illuminate\Support\Facades\Mail;
use memento\Mail\EmailReminder;



class SendReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request, Todo $todo)
    {
        $todos = Todo::whereMonth('when', '=', date('m'))->whereDay('when', '=', date('d'))->get();  

        $todos = $todos->load('appointment');

        foreach($todos as $todo){
            $user = User::where('id', $todo->appointment->user_id)->first();
            $schedule = Schedule::where('id', $todo->appointment->schedule_id)->first();
            $praticien = User::where('id', $schedule->user_id)->first();
            $email = $user->email;

            Mail::to($email)->send( new EmailReminder($todo, $user, $praticien));
        }

    }
}
