@extends('layouts.admin')
@section('content')
@section('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printarea,
        #printarea * {
            visibility: visible;
        }

        #printarea {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endsection
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                </div>
                <div class="col-md-4">
                    @can("Return Penjualan")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('returnsell.index') }}"><i class="fa fa-list"></i> {{__('sell.return_sell')}}</a>
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
                                    <p class="pull-right"><b>{{__('general.date')}} :</b> {{ my_date($return->created_at) }} </p>
                                    <p class="pull-right" style="margin-top:-15px;"><b>{{__('purchase.parent_transaction')}} :</b> {{ $return->transaction->ref_no }} </p>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-6 ">
                                    {{__('sidebar.supplier')}}:
                                    <address>
                                        {{ $return->customer->name ?? '' }},
                                        {{ $return->customer->city ?? '' }} {{ $return->customer->address ?? '' }}
                                        <br>{{__('general.phone')}}: {{ $return->customer->phone ?? '' }}
                                    </address>
                                </div>

                                <div class="col-sm-6 ">
                                    {{__('general.store')}}:
                                    <address>
                                        <strong>{{ $return->store->name ?? '' }},</strong>
                                        <br> {{ $return->store->address ?? '' }}
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
                                                    <th>{{__('purchase.return_qty')}}</th>
                                                    <th>{{__('purchase.unit_cost')}} </th>
                                                    <th>{{__('sell.condition')}} </th>
                                                    <th class="text-right">{{__('general.subtotal')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = 1;
                                                $jumlah = 0;
                                                @endphp
                                                @foreach($return->sellreturn as $gd )

                                                @php
                                                $subtotal = 0;
                                                $subtl = 0;
                                                $subtl += $gd->sell->unit_price * $gd->return_qty;
                                                $jumlah += $subtl;
                                                @endphp
                                                @if($gd->return_qty != 0)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        {{$gd->sell->product->name ?? ''}} @if($gd->sell->variation->name != 'no-name') {{ ' - '. $gd->sell->variation->name ?? '' }} @endif
                                                    </td>
                                                    <td> {{ $gd->return_qty }} </td>
                                                    <td> {{ number_format($gd->sell->unit_price)}} </td>
                                                    <td>{{ $condition[$gd->condition] }}</td>
                                                    <td>{{ number_format($subtl) }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <small>{{__('sell.alert_condition')}} </small>
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
                            <div class="row">

                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-xs-12">
                                        <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($return->ref_no, 'C39') }}">
                                        <p><b>{{ $return->ref_no }}</b></p>
                                    </div>
                                </div>
                                @can("Print Return")
                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-12">
                                        <a target="_blank" href="{{ route('returnsell.print',$return->id) }}" class="btn btn-primary"><i class="fas fa-print"></i> {{__('purchase.return_print')}}</a>
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