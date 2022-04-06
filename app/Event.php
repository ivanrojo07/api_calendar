<?php

namespace App;
use App\Project;
use App\Timezone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Eluceo\iCal\Component\Calendar as iCalendar;
use Eluceo\iCal\Component\Event as iEvent;
use Eluceo\iCal\Property\Event\Geo;

class Event extends Model
{
    use SoftDeletes;    
    protected $fillable = [
        'empresa_id',
        'sucursal_id',
        'usuario_id',
        'supervisor_id',
        'project_id',
        'contacto_id',
        'titulo',
        'descripcion',
        'direccion',
        'latitud',
        'longitud',
        'tipoevento',
        'fecharegistro',
        'inicio',
        'fin',
        'recordatorio',
        'temporizador',
        'recurrente',
        'periodo',
        'url'
    ];

    protected $hidden=['deleted_at','created_at','updated_at'];


    public function lists()
    {
    	return $this->hasMany('App\Lista');
    }
    
    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function timezone(){
    	return $this->belongsTo('App\Timezone');
  	}

  	/**
     * Get the participants for the event.
     */
    public function participants()
    {
        return $this->hasMany('App\Participante');
    }

    
    public function getFechaInicioAttribute(){

		$fecha=$this->inicio;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);

			return $splitfecha[0];

		}
		return null;
  	}
      
  	public function getHoraInicioAttribute(){
        // $splithora=explode(' ',$this->fechainicio);
        $fecha=$this->inicio;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);
			return $splitfecha[1];

		}
		return null;
		//$splithora[1];
  	}

	public function getFechaFinAttribute()
	{
		$fecha=$this->fin;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);
			return $splitfecha[0];
		}
		return null;
	}

	public function getHoraFinAttribute()
	{
		$fecha=$this->fin;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);
			return $splitfecha[1];
		}
		return null;
	}

	public function getFechaRecordatorioAttribute()
	{
		$fecha=$this->recordatorio;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);
			return $splitfecha[0];
		}
		return null;
	}

	public function getHoraRecordatorioAttribute()
	{
		$fecha=$this->recordatorio;
		if ($fecha) {
			$splitfecha = explode(" ",$fecha);
			return $splitfecha[1];
		}
		return null;
	}

	public function getIevent()
	{
		$iCalendar = $this->crearCalendario($this->titulo,[$this]); 
		return $iCalendar;
	}

	public function getCalendarUser($user_id)
	{
		$events = $this->where('usuario_id',$user_id)->orWhere('supervisor_id',$user_id)->get();
		$iCalendar = $this->crearCalendario("Calendario $user_id",$events);
		return $iCalendar;
	}

	private function crearCalendario($titulo="Calendario",$events){
		$iCalendar = new iCalendar($titulo);
		$iCalendar->setName($titulo);
		$iCalendar->setTimezone('UTC');
		foreach ($events as $event) {
	    	$iEvent = new iEvent();
	    	$iEvent->setSummary($event->titulo);
	    	if ($event->descripcion) {
	      		$iEvent->setDescription($event->descripcion);
	    	}
	    	if ($event->inicio) {
	      		$iEvent->setDtStart(new \DateTime($event->inicio));
	    	}
	    	if ($event->fin) {
	      		$iEvent->setDtEnd(new \DateTime($event->fin));
	      
	    	}
	    	if($event->url){
	      		$iEvent->setUrl($event->url); 
	      
	    	}
	    	if($event->latitud && $event->longitud){
	      
	      		// optionally a location with a geographical position can be created
	      		$iEvent->setGeoLocation(new Geo($event->latitud, $event->longitud));
    		}
	    	if($event->recurrente === 'true'){
		      	/**
		         * The FREQ rule part identifies the type of recurrence rule.  This
		         * rule part MUST be specified in the recurrence rule.  Valid values
		         * include.
		         *
		         * SECONDLY, to specify repeating events based on an interval of a second or more;
		         * MINUTELY, to specify repeating events based on an interval of a minute or more;
		         * HOURLY, to specify repeating events based on an interval of an hour or more;
		         * DAILY, to specify repeating events based on an interval of a day or more;
		         * WEEKLY, to specify repeating events based on an interval of a week or more;
		         * MONTHLY, to specify repeating events based on an interval of a month or more;
		         * YEARLY, to specify repeating events based on an interval of a year or more.
		         *
		         * @param string $freq
		         *
		         * @return $this
		         *
		         * @throws \InvalidArgumentException
		         */
		      	// Set recurrence rule
		      	$recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
		      	$recurrenceRule->setFreq($event->periodo);
		      	$recurrenceRule->setInterval(1);
	      		$iEvent->setRecurrenceRule($recurrenceRule);
		      	// $iEvent->setFreq($event->periodo);
	    	}

	    	$iCalendar->addComponent($iEvent);
		}
		return $iCalendar;
  	}

}
