<?php

namespace App\Http\Controllers\Event;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class EventProjectController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $evento)
    {
        $projects=$evento->project;

       // return $this->showAll($projects);
        return response()->json(['data'=>$projects],202);
    }

 
}
