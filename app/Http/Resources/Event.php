<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    return [
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
            'sucursal_id' => $this->sucursal_id,
            'usuario_id' => $this->usuario_id,
            'supervisor_id' => $this->supervisor_id,
            'participantes' => $this->participants()->pluck('usuario_id'),
            'project' => $this->project,
            'contacto_id' =>$this->contacto_id,
          
            'titulo' =>$this->titulo,
            'descripcion' => $this->descripcion,
            'direccion' => $this->direccion,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'tipoevento' => $this->tipoevento,
            'inicio'=>$this->inicio,
            'fin'=>$this->fin,
            'recordatorio'=>$this->recordatorio,
            'fecharegistro' => $this->fecharegistro,
            'fechainicio'=> $this->fecha_inicio,
            'horainicio' => $this->hora_inicio,
            'fechafin' => $this->fecha_fin,
            'horafin' => $this->hora_fin,
            'fecharecordatorio' => $this->fecha_recordatorio,
            'horarecordatorio' => $this->hora_recordatorio,
            'temporizador' => $this->temporizador,
            'recurrente' => $this->recurrente,
            'periodo' => $this->periodo,
            'url' => $this->url
           ];
    }
}
