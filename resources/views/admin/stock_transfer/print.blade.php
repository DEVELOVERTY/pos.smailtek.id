<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page }}</title>
    @yield('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <style type="text/css">
       
        @media  print{
           

        }
    </style>
    <script>window.print()</script>
</head>

<body> 
   <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card"> 
                <div class="card-content">
                    <div class="card-body" id="printarea">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="pull-right"><b>{{__('general.date')}} :</b> {{ my_date($transfer->created_at) }} </p> 
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-6 ">
                                {{__('transfer.from')}} :
                                <address>
                                    {{$transfer->transfer->fromstore->name ?? '' }}, 
                                    <br>{{__('general.phone')}} : {{ $transfer->transfer->fromstore->phone ?? '' }}
                                    <br>{{__('general.address')}} : {{ $transfer->transfer->fromstore->address ?? '' }}
                                </address>
                            </div>

                            <div class="col-sm-6 ">
                                {{__('transfer.to')}} :
                                <address>
                                    <strong>{{ $transfer->transfer->tostore->name ?? '' }},</strong>
                                    <br>{{__('general.phone')}} : {{ $transfer->transfer->tostore->phone ?? '' }}
                                    <br>{{__('general.address')}} : {{ $transfer->transfer->tostore->address ?? '' }}
                                </address>
                            </div>
 
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('produk.name')}}</th>
                                                <th>{{__('purchase.quantity')}}</th>
                                                <th>{{__('purchase.unit_cost')}}</th>
                                                <th class="text-right">{{__('general.subtotal')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $no = 1;
                                            $jumlah = 0;
                                            @endphp 
                                        @foreach($transfer->manytransfer as $gd ) 
                                        @php 
                                        $subtotal = 0;
                                        $subtl = 0; 
                                        $subtl += $gd->stock->variation->purchase_price * $gd->transfer_qty;
                                        $jumlah += $subtl; 
                                        @endphp 
                                        @if($gd->transfer_qty != 0)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                               {{$gd->stock->variation->product->name ?? ''}} @if($gd->stock->variation->name != 'no-name') {{ ' - '. $gd->stock->variation->name ?? '' }} @endif
                                            </td>
                                            <td> {{ $gd->transfer_qty }}  </td>
                                            <td> {{ number_format($gd->stock->variation->purchase_price)}}  </td>  
                                            <td>{{ number_format($subtl) }}</td> 
                                        </tr> 
                                        @endif
                                        @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row"> 
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="table-responsive">
                                    <table class="table"> 
                                        <tbody>
                                            <tr>
                                                <th>{{__('purchase.shipping_cost')}} : </th>
                                                <td></td>
                                                <td>{{number_format($transfer->shipping_charges)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('purchase.net_total')}} : </th>
                                                <td></td>
                                                <td>{{number_format($jumlah)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('general.total')}} : </th>
                                                <td></td>
                                                <td>{{number_format($transfer->final_total)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                          
                         <div class="row text-center mt-5 mb-3">
                            <div class="col-12">
                                <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($transfer->ref_no, 'C39') }}">
                                <p ><b>{{ $transfer->ref_no }}</b></p>
                            </div>
                        </div> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>