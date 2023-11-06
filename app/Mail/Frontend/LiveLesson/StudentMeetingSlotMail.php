<?php

namespace App\Mail\Frontend\LiveLesson;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentMeetingSlotMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.studentMeetingSlotMail')
            ->subject('Live Lesson Booked Slot Details '.env('APP_NAME'))
            ->with('content',$this->content);
    }
}
