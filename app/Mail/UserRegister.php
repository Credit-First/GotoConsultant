<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $type)
    {   
      $this->name = $name;
      $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      if ($this->type == "consultant") {
        $subject = "Welcome to a world of consulting!";
      } else {
        $subject = "Welcome to GotoConsult!";
      }
      return $this->view('email.user-register', [
        'name' => $this->name
      ])
      ->from("no-reply@gotoconsult.com", "GotoConsult")
      ->subject($subject);
    }
}
