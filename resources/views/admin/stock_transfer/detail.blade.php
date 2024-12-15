@extends('layouts.admin')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Daftar Stock Transfer")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('transfer.index') }}"><i class="fa fa-list"></i> {{__('sidebar.stock_transfer')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
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
                                                    <td> {{ $gd->transfer_qty }} </td>
                                                    <td> {{ number_format($gd->stock->variation->purchase_price)}} </td>
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
                            <div class="row">

                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-xs-12">
                                        <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($transfer->ref_no, 'C39') }}">
                                        <p><b>{{ $transfer->ref_no }}</b></p>
                                    </div>
                                </div>
                                @can("Print Stock Transfer")
                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-12">
                                        <a target="_blank" href="{{ route('transfer.print',$transfer->id) }}" class="btn btn-primary"><i class="fas fa-print"></i> {{__('transfer.print')}}</a>
                                    </div>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection