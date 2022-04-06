<?php

namespace App\Mail;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IcalendarEvent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The event instance.
     *
     * @var Event
     */
    protected $event;

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
     * Create a new asunto instance.
     *
     * @return void
     */
    public function __construct(Event $event,$asunto=null,$body=null)
    {
        //
        $this->event = $event;
        $this->asunto = $asunto;
        $this->body = $body;
        $calendar = $event->getIevent();
        $this->iCalendar = $calendar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->asunto)->markdown('emails.event',[
            'event'=>$this->event,
            'body'=>$this->body
        ])->attachData($this->iCalendar,$this->event->titulo.".ics",[
            'mime' => 'text/calendar; charset=utf-8'
        ]);
    }
}
