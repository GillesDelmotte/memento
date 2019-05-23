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
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($todo, $user, $praticien, $message)
    {
        $this->todo = $todo;
        $this->user = $user;
        $this->praticien = $praticien;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('email.reminder', ['text' => $this->message, 'user' => $this->user, 'todo' => $this->todo, 'praticien' => $this->praticien ]);
    }
}
