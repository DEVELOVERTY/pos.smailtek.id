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
                                <p class="pull-right"><b>{{__('general.date')}} : </b> {{ my_date($purchase->created_at) }} </p>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                {{__('sidebar.supplier')}}:
                                <address>
                                    {{ $purchase->supplier->name }},
                                    {{ $purchase->supplier->city . ' ' . $purchase->supplier->address }}
                                    <br>{{__('general.phone')}} : {{ $purchase->supplier->phone }}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                {{__('general.store')}} :
                                <address>
                                    <strong>{{ $purchase->store->name }},</strong>
                                   <br> {{ $purchase->store->address }}
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>{{__('general.ref_no')}} : </b> #{{ $purchase->ref_no }}<br>
                                <b>{{__('general.date')}} : </b> {{ $purchase->created_at }}<br>
                                <b>{{__('purchase.received_status')}} :</b> {{ $status[$purchase->status] }}<br>
                                <b>{{__('general.payment_status')}} :</b> {{ $payment[$purchase->payment_status] }}<br> 
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
                                                <th>{{__('produk.code')}}</th>
                                                <th >{{__('purchase.quantity')}} </th>
                                                <th >{{__('purchase.unit_cost')}} (<span style="font-size: 10px;">{{__('purchase.before_discount')}}</span>)</th>
                                                <th >{{__('purchase.discount_percentase')}}</th>
                                                <th >{{__('purchase.tax')}}</th> 
                                                <th >{{__('purchase.unit_cost')}} (<span style="font-size: 10px;">{{__('purchase.before_tax')}}</span>)</th>
                                                <th >{{__('purchase.unit_cost')}} (<span style="font-size: 10px;">{{__('purchase.after_tax')}}</span>)</th> 
                                                <th class="text-right">{{__('general.sell_price')}}</th>
                                                <th class="text-right">{{__('general.subtotal')}} (<span style="font-size: 10px;">{{__('purchase.before_tax')}}</span>)</th>
                                                <th class="text-right">{{__('general.subtotal')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                            $no = 1;
                                            $jumlah = 0;
                                            @endphp 
                                        @foreach($getDetail as $gd )
                                        
                                        @php 
                                        $subtotal = 0;
                                        $subtl = 0;
                                        
                                        $subtl += $gd->purchase_price * $gd->quantity;
                                        $jumlah += $subtl;
                                        $subtotal += $gd->purchase_price_inc_tax * $gd->quantity;
                                        @endphp 
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                               {{$gd->variation->product->name ?? ''}} @if($gd->variation->name != 'no-name') {{ ' - '. $gd->variation->name ?? '' }} @endif
                                            </td>
                                            <td> {{ $gd->variation->sku ?? '' }}  </td>
                                            <td> {{ $gd->quantity}}  </td>
                                            <td>{{ number_format($gd->without_discount) }} </td>
                                            <td  > {{ $gd->discount_percent }}  %</td>
                                            <td>{{ $gd->item_tax }}</td>
                                            <td> {{ number_format($gd->purchase_price) }} </td>
                                            <td> {{ number_format($gd->purchase_price_inc_tax) }} </td> 
                                            <td> {{number_format($gd->variation->selling_price)}}</td>
                                            <td> {{number_format($subtl)}}</td>
                                            <td>{{ number_format($subtotal) }}</td> 
                                        </tr>
                                        @endforeach
                                           
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <h4>{{__('general.payment_info')}} :</h4>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>#</th>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__('general.ref_no')}}</th>
                                                <th>{{__('general.payment_total')}}</th>
                                                <th>{{__('general.payment_method')}}</th>
                                                <th>{{__('general.payment_note')}}</th>
                                            </tr>
                                            @php 
                                            if(count($purchase->paycredit) == 0) {
                                                echo '  <tr><td colspan="5" class="text-center">No payments found </td></tr>';
                                            } else {
                                                foreach ($purchase->paycredit as $pay) {
                                                    if($pay->method == 'cash') {
                                                        $method = 'Cash';
                                                    } else if($pay->method == 'bank_transfer') {
                                                        $method = 'Bank Transfer';
                                                    } else if($pay->method == 'card') {
                                                        $method = 'Card';
                                                    } else if($pay->method == 'other') {
                                                        $method = 'Lainnya';
                                                    }
                                                   echo '<tr>
                                                        <td>#</td>
                                                        <td>'.$pay->created_at.'</td>
                                                        <td>'.$purchase->ref_no.'</td>
                                                        <td>'.number_format($pay->amount).'</td>
                                                        <td>'.$method.'</td>
                                                        <td>'.$pay->note.'</td>
                                                    </tr>';
                                                }
                                            }
                                            @endphp 
                                           
                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <div class="table-responsive">
                                    <table class="table"> 
                                        <tbody>
                                            <tr>
                                                <th>{{__('purchase.net_total')}} : </th>
                                                <td></td>
                                                <td>{{number_format($jumlah)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('purchase.discount_amount')}} :</th>
                                                <td>
                                                    <b>(-)</b>
                                                </td>
                                                <td> {{ number_format($purchase->discount_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('purchase.purchase_tax')}} :</th>
                                                <td><b>(+)</b></td>
                                                <td class="text-right">
                                                   {{number_format($purchase->tax_amount)}}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{__('purchase.shipping_cost')}} :</th>
                                                <td><b>(+)</b></td>
                                                <td>{{ number_format($purchase->shipping_charges) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{__('general.total')}} :</th>
                                                <td></td>
                                                <td>{{ number_format($purchase->final_total) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>{{__('purchase.shipping_detail')}}:</strong><br>
                                <p style="background-color: #d2d6de; border-radius:10px;" class="p-2">
                                    {{ $purchase->shipping_details }}
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <strong>{{__('general.note')}} :</strong><br>
                                <p style="background-color: #d2d6de; border-radius:10px;" class="p-2">
                                    {{ $purchase->additional_notes }}
                                </p>
                            </div>
                        </div>
                     


                        <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($purchase->ref_no, 'C39') }}">
                                    <p ><b>{{ $purchase->ref_no }}</b></p>
                                </div>
                            </div>
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>