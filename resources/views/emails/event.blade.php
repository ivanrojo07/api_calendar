@component('mail::message')
# Evento "{{$event->titulo}}"

@if ($body)
	{{$body}}
@else
	Se creo un nuevo evento a tu agenda 360.
@endif

{{-- @component('mail::button', ['url' => "#"])
View Order
@endcomponent --}}

Gracias,<br>
{{ config('app.name') }}
@endcomponent