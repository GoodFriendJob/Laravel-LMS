<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrederMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content, $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $admin)
    {
        $this->content = $content;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails/adminOrderMail',['admin' => $this->admin])
            ->subject('Regarding New Order on '.env('APP_NAME'))
            ->with('content',$this->content);
    }
}
