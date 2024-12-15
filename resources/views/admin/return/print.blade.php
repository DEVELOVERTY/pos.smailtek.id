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
                                <p class="pull-right"><b>{{__('general.date')}} :</b> {{ my_date($return->created_at) }} </p>
                                <p class="pull-right" style="margin-top:-15px;"><b>{{__('purchase.parent_transaction')}} :</b> {{ $return->transaction->ref_no }} </p>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-6 ">
                                {{__('sidebar.supplier')}}:
                                <address>
                                    {{ $return->supplier->name }},
                                    {{ $return->supplier->city . ' ' . $return->supplier->address }}
                                    <br>{{__('general.phone')}}: {{ $return->supplier->phone }}
                                </address>
                            </div>

                            <div class="col-sm-6 ">
                                {{__('general.store')}}:
                                <address>
                                    <strong>{{ $return->store->name }},</strong>
                                   <br> {{ $return->store->address }}
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
                                                <th>{{__('purchase.return_qty')}}</th>
                                                <th>{{__('purchase.unit_cost')}} </th>
                                                <th class="text-right">{{__('general.subtotal')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $no = 1;
                                            $jumlah = 0;
                                            @endphp 
                                        @foreach($return->returndetail as $gd )
                                        
                                        @php 
                                        $subtotal = 0;
                                        $subtl = 0; 
                                        $subtl += $gd->purchase->purchase_price * $gd->return_qty;
                                        $jumlah += $subtl; 
                                        @endphp 
                                        @if($gd->return_qty != 0)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                               {{$gd->purchase->product->name ?? ''}} @if($gd->purchase->variation->name != 'no-name') {{ ' - '. $gd->purchase->variation->name ?? '' }} @endif
                                            </td>
                                            <td> {{ $gd->return_qty }}  </td>
                                            <td> {{ number_format($gd->purchase->purchase_price)}}  </td>  
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
                                                <th>{{__('purchase.net_total')}}: </th>
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
                                <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($return->ref_no, 'C39') }}">
                                <p ><b>{{ $return->ref_no }}</b></p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>