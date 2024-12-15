<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page }}</title>
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" >
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <style type="text/css">
        @media print {}

    </style>
    <script>
        window.print()
    </script>
</head>

<body>

    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card"> 
                <div class="card-content">
                    <div class="card-body" id="printarea">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="pull-right"><b>{{__('general.date')}}:</b> {{ my_date($adjustment->created_at) }} </p> 
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-12 ">
                                {{__('general.store')}}:
                                <address>
                                    {{$adjustment->store->name ?? '' }}, 
                                    <br>{{__('general.phone')}} : {{ $adjustment->store->phone ?? '' }}
                                    <br>{{__('general.address')}} : {{ $adjustment->store->address ?? '' }}
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
                                                <th>{{__('purchase.unit_cost')}} </th>
                                                <th class="text-right">{{__('general.subtotal')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $no = 1;
                                            $jumlah = 0;
                                            @endphp 
                                        @foreach($adjustment->adjustment as $gd ) 
                                        @php 
                                        $subtotal = 0;
                                        $subtl = 0; 
                                        $subtl += $gd->variation->purchase_price * $gd->qty_adjustment;
                                        $jumlah += $subtl; 
                                        @endphp  
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                               {{$gd->variation->product->name ?? ''}} @if($gd->variation->name != 'no-name') {{ ' - '. $gd->variation->name ?? '' }} @endif
                                            </td>
                                            <td> {{ $gd->qty_adjustment }}  </td>
                                            <td> {{ number_format($gd->variation->purchase_price)}}  </td>  
                                            <td>{{ number_format($subtl) }}</td> 
                                        </tr>  
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
                                                <th>{{__('purchase.net_total')}} : </th>
                                                <td></td>
                                                <td>{{number_format($jumlah)}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                        <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <img class="center-block"
                                        src="data:image/png;base64, {{ DNS1D::getBarcodePNG($adjustment->ref_no, 'C39') }}">
                                    <p><b>{{ $adjustment->ref_no }}</b></p>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
