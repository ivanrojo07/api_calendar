<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;


class IcalendarController extends Controller
{
    //

    public function getEvent(Event $event){
    	$iCalendar = $event->getIevent(); 

		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$event->titulo.'.ics"');
		return response($iCalendar->render());

    }

    public function getUsuarioCalendar($usuario_id)
    {
    	$event = new Event();
        $iCalendar = $event->getCalendarUser($usuario_id);
        header('Content-Type: text/calendar; charset=utf-8');
                header('Content-Disposition: attachment; filename="'.$usuario_id.'.ics"');
                return response($iCalendar->render());

    }
}