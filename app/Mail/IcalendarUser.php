<?php

namespace App\Mail;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IcalendarUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The events instance.
     *
     * @var Event
     */
    protected $user_id;

    /**
     * The asunto instance.
     *
     * @string asunto
     */
    protected $asunto;

    /**
     * The body instance.
     *
     * @string body
     */
    protected $body,$iCalendar;
    
    /**

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id,$asunto=null,$body=null)
    {
        //
        $this->user_id = $user_id;
        $this->asunto = $asunto;
        $this->body = $body;
        $event = new Event();
        $calendar = $event->getCalendarUser($this->user_id);
        $this->iCalendar = $calendar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->asunto)->markdown('emails.calendar',[
            'user_id'=>$this->user_id,
            'body'=>$this->body
        ])->attachData($this->iCalendar,$this->user_id.".ics",[
            'mime' => 'text/calendar; charset=utf-8'
        ]);
    }
}
