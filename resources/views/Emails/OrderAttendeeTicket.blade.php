@extends('Emails.Layouts.Master')

@section('message_content')

@lang("basic.hello") {{ $attendee->first_name }},<br><br>

<p>Puede ver los detalles de su pedido y descargar sus entradas en:</p> <a href="{{ Storage::disk('s3')->url(config('attendize.event_pdf_tickets_path') . '/' . $attendee->order->order_reference . '.pdf') }}">
Lollypop_tickets
</a>.

@stop

