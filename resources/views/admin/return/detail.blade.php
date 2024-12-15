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
                    @can("Daftar Return")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('return.index') }}"><i class="fa fa-list"></i> {{__('sidebar.return')}}</a>
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
                                        {{ $return->supplier->name ?? '' }},
                                        {{ $return->supplier->city ?? '' }} {{ $return->supplier->address ?? '' }}
                                        <br>{{__('general.phone')}}: {{ $return->supplier->phone ?? '' }}
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
                                                    <td> {{ $gd->return_qty }} </td>
                                                    <td> {{ number_format($gd->purchase->purchase_price)}} </td>
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
                                                    <td><b>{{number_format($jumlah)}}</b></td>
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
                                        <a target="_blank" href="{{ route('return.print',$return->id) }}" class="btn btn-primary"><i class="fas fa-print"></i> {{__('purchase.return_print')}}</a>
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