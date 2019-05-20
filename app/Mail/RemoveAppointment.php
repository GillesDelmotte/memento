<?php

namespace memento\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveAppointment extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $hour;
    protected $date;
    protected $practitien;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $hour, $date, $practitien)
    {
        $this->user = $user;
        $this->hour = $hour;
        $this->date = $date;
        $this->practitien = $practitien;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.RemoveAppointment', ['user' => $this->user, 'hour' => $this->hour, 'date' => $this->date, 'practitien' => $this->practitien]);
    }
}
