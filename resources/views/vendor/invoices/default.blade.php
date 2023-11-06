<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->name }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1, h2, h3, h4, span, p, div {
            font-family: DejaVu Sans;
        }


    </style>
</head>
<body>
<div style="display: block;clear: both">
    <div style="float: left; width:250pt;">
        <img class="img-rounded" height="50px"
             src="{{ asset('storage/logos/'.config('logo_b_image')) }}">
    </div>
    <div style="float: right;width: 180pt;">
        <h5>Date: <b> {{ $invoice->date->formatLocalized('%A %d %B %Y') }}</b></h5>
        @if ($invoice->number)
            <h5>Invoice #: <b>{{strval($invoice->number) }}</b></h5>
        @endif
    </div>
</div>
<div style="display: inline-block;clear: both;width: 100%;">
    <hr>

    <div style="width:300pt; float:left;">
        <h4>Business Details:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                @if(config('contact_data') != "")
                    @php
                        $contact_data = contact_data(config('contact_data'));
                    @endphp
                    <h4 style="font-weight: bold;">{{env('APP_NAME')}}</h4>

                    @if($contact_data["primary_address"]["status"] == 1)
                        <span>Address: {{$contact_data["primary_address"]["value"]}} </span><br>
                    @endif

                    @if($contact_data["primary_phone"]["status"] == 1)
                        {{--{{dd($contact_data["primary_phone"]["value"])}}--}}
                        <span style="font-family: Helvetica, Arial, sans-serif;">Contact No.: {{ $contact_data["primary_phone"]["value"]}}</span>
                        <br>
                    @endif

                    @if($contact_data["primary_email"]["status"] == 1)
                        <span> Email : {{$contact_data["primary_email"]["value"]}} </span><br>
                    @endif
                @else
                    <i>No business details</i><br/>
                @endif
            </div>
        </div>
    </div>
    <div style="float: right; width:200pt;height: auto;display: inline-block">
        <h4>Customer Details:</h4>
        <div class="panel panel-default" style="padding: 15px;padding-top: 0px">
            {!! $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : '' !!}
            <h4 style="font-weight: bold; font-family: DejaVu Sans;"> {{ $invoice->customer_details->get('name') }}</h4>
            <span>Email :</span> {{ $invoice->customer_details->get('email') }}
        </div>
    </div>
</div>

<div style="clear:both;display: block;">
    <h4>Items:</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Item Name</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->items as $key=>$item)
            @php $key++ @endphp
            <tr>
                <td>{{$key}}</td>
                <td>{{ $item->get('id') }}</td>
                <td style=" font-family: DejaVu Sans;">{{ $item->get('name') }}</td>
                <td class="text-right">{{ $item->get('totalPrice') }} {{ $invoice->formatCurrency()->symbol }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="clear:both; position:relative;">

        {{--<div style="float: right;">--}}
        {{--<h4>Total: <b>{{ $invoice->totalPriceFormatted() }} {{ $invoice->formatCurrency()->symbol }}</b></h4>--}}

        {{--</div>--}}
        <div style="margin-left: 300pt;">
            <h4>Total:</h4>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><b>Subtotal</b></td>
                    <td class="text-right">{{ $invoice->subTotalPriceFormatted() }} {{ $invoice->formatCurrency()->symbol }}</td>
                </tr>
                @if($invoice->discount != null)
                    <tr>
                        <td><b> - Discount</b></td>
                        <td class="text-right">{{$invoice->discount }} {{ $invoice->formatCurrency()->symbol }}</td>
                    </tr>
                @endif
                @if($invoice->taxData != null)
                    @foreach($invoice->taxData as $tax)
                        <tr>
                            <td>
                                + {{$tax['name']}}
                            </td>
                            <td class="text-right">{{ number_format( $tax['amount'],2) }} {{ $invoice->formatCurrency()->symbol }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td><b>TOTAL</b></td>
                    <td class="text-right"><b>{{ $invoice->total }} {{ $invoice->formatCurrency()->symbol }}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($invoice->footnote)
    <br/><br/>
    <div class="well">
        {{ $invoice->footnote }}
    </div>
@endif
</body>
</html>
