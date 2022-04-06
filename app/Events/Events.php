<?php

namespace App\Events;

use App\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\Event as EventResource;

class Events implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event,$type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $event, $type)
    {
        //
        $this->event = new EventResource($event);
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        array_push($channels, new Channel('event_user.'.$this->event->usuario_id));
        if ($this->event['supervisor_id']) {
            array_push($channels, new Channel('event_user.'.$this->event['supervisor_id']));
        }
        if ($this->event->participants) {
            foreach ($this->event->participants as $participante) {
                if($participante->usuario_id != $this->event->usuario_id && $participante->usuario_id != $this->event->supervisor_id){
                   array_push($channels, new Channel('event_user.'.$participante->usuario_id)); 
                }
            }
        }
        return $channels;
    }


    public function broadcastAs()
    {

        switch ($this->type) {
            case "new":
                $event_type = "new_event";
                break;
            
            case "update":
                $event_type = "update_event";
                break;

            case "delete":
                $event_type = "delete_event";
                break;
            
            default:
                $event_type = "new_event";
                break;
        }
       return $event_type;
    }
}
