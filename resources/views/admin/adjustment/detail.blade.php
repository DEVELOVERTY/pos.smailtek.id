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
                    @can("Daftar Adjustment")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('adjustment.index') }}"><i class="fa fa-list"></i> {{__('sidebar.list_adjs')}}</a>
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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
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
                                                    <td> {{ $gd->qty_adjustment }} </td>
                                                    <td> {{ number_format($gd->variation->purchase_price)}} </td>
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
                            <div class="row">

                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-xs-12">
                                        <img class="center-block" src="data:image/png;base64, {{ DNS1D::getBarcodePNG($adjustment->ref_no, 'C39') }}">
                                        <p><b>{{ $adjustment->ref_no }}</b></p>
                                    </div>
                                </div>
                                @can("Print Adjustment")
                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-12">
                                        <a target="_blank" href="{{ route('adjustment.print',$adjustment->id) }}" class="btn btn-primary"><i class="fas fa-print"></i> {{__('general.print')}}</a>
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