@extends('Emails.Layouts.Master')

@section('message_content')

@lang("basic.hello") {{ $attendee->first_name }},<br><br>

<p>¡Tus entradas han llegado! Están adjuntas a este correo.</p>

@stop


