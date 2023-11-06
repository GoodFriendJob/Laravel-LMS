<?php

use Illuminate\Mail\Mailable;

class SendEmail extends Mailable
{
    public $name;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message)
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send_email')
                    ->subject('Example Email');
    }
}