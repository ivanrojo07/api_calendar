<?php

namespace App\Http\Controllers;

use App\Timezone;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TimezoneController extends ApiController
{
    public function index()
    {
        $timezones=Timezone::all();
        return $this->showAll($timezones);
    }

  
    public function create()
    {
        //
    }

    

    public function store(Request $request)
    {
        //
    }

    
    public function show(Timezone $timezone)
    {
        //
    }

   

    public function edit(Timezone $timezone)
    {
        //
    }

   

    public function update(Request $request, Timezone $timezone)
    {
        //
    }

   
    public function destroy(Timezone $timezone)
    {
    
    }
}
