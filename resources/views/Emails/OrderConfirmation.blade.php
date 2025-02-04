@extends('Emails.Layouts.Master')

@section('message_content')
@lang("basic.hello"),<br><br>

{!! @trans("Order_Emails.successful_order", ["name" => $order->event->title]) !!}<br><br>

<p>Tus tickets serán enviados a este correo electrónico.</p>

@if(!$order->is_payment_received)
<br><br>
<strong>{{ @trans("Order_Emails.order_still_awaiting_payment") }}</strong>
<br><br>
{{ $order->event->offline_payment_instructions }}
<br><br>
@endif

<h3>Detalles del pedido</h3>
Referencia del pedido: <strong>{{$order->order_reference}}</strong><br>
Nombre del pedido: <strong>{{$order->full_name}}</strong><br>
Fecha del pedido: <strong>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</strong><br>
Correo electrónico del pedido: <strong>{{$order->email}}</strong><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Añadir al calendario</a>

@if ($order->is_business)
<h3>Detalles de la empresa</h3>
@if ($order->business_name) @lang("Public_ViewEvent.business_name"): <strong>{{$order->business_name}}</strong><br>@endif
@if ($order->business_tax_number) @lang("Public_ViewEvent.business_tax_number"): <strong>{{$order->business_tax_number}}</strong><br>@endif
@if ($order->business_address_line_one) @lang("Public_ViewEvent.business_address_line1"): <strong>{{$order->business_address_line_one}}</strong><br>@endif
@if ($order->business_address_line_two) @lang("Public_ViewEvent.business_address_line2"): <strong>{{$order->business_address_line_two}}</strong><br>@endif
@if ($order->business_address_state_province) @lang("Public_ViewEvent.business_address_state_province"): <strong>{{$order->business_address_state_province}}</strong><br>@endif
@if ($order->business_address_city) @lang("Public_ViewEvent.business_address_city"): <strong>{{$order->business_address_city}}</strong><br>@endif
@if ($order->business_address_code) @lang("Public_ViewEvent.business_address_code"): <strong>{{$order->business_address_code}}</strong><br>@endif
@endif

<h3>Artículos del pedido</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <strong>Entrada</strong>
            </td>
            <td>
                <strong>Cantidad</strong>
            </td>
            <td>
                <strong>Precio</strong>
            </td>
            <td>
                <strong>Tarifa</strong>
            </td>
            <td>
                <strong>Total</strong>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>{{$order_item->title}}</td>
            <td>{{$order_item->quantity}}</td>
            <td>
                @isFree($order_item->unit_price)
                GRATIS
                @else
                {{money($order_item->unit_price, $order->event->currency)}}
                @endif
            </td>
            <td>
                @isFree($order_item->unit_price)
                -
                @else
                {{money($order_item->unit_booking_fee, $order->event->currency)}}
                @endif
            </td>
            <td>
                @isFree($order_item->unit_price)
                GRATIS
                @else
                {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td><strong>Subtotal</strong></td>
            <td colspan="2">
                {{$orderService->getOrderTotalWithBookingFee(true)}}
            </td>
        </tr>
        @if($order->event->organiser->charge_tax == 1)
        <tr>
            <td colspan="3"></td>
            <td>
                <strong>{{$order->event->organiser->tax_name}}</strong><em>({{$order->event->organiser->tax_value}}%)</em>
            </td>
            <td colspan="2">
                {{$orderService->getTaxAmount(true)}}
            </td>
        </tr>
        @endif
        <tr>
            <td colspan="3"></td>
            <td><strong>Total</strong></td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>
    <br><br>
</div>
<br><br>
Gracias
@stop
