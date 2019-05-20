<?php

namespace memento\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailReminder extends Mailable
{
    use Queueable, SerializesModels;
    protected $todo;
    protected $user;
    protected $practitien;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todo, $user, $praticien)
    {
        $this->todo = $todo;
        $this->user = $user;
        $this->praticien = $praticien;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.reminder', ['user' => $this->user, 'todo' => $this->todo, 'praticien' => $this->praticien]);
    }
}
