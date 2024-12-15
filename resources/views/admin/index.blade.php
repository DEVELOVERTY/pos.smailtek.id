@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}">
@endsection


<div class="page-content">
    <div class="container-fluid">

        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title">{{$page}}</h6>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Selamat datang Kembali {{Auth()->user()->name}} </li>
                    </ol>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-lx-8 col-sm-12">
                @can("Penjualan 30")
                <div class="card">
                    <div class="card-body mt-2">
                        <div id="sellMonth"></div>
                    </div>
                </div>
                @endif
                <div class="row">
                    @can('Laporan Purchase')
                    <div class="col-12 col-lg-6 col-xl-4">
                        <a href="{{ route('purchase.report') }}" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4">{{ my_currency($data['total_purchase']) }}</span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0">{{__('purchase.purchase_total')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endcan
                    @can('Laporan Hutang')
                    <div class="col-12 col-lg-6 col-xl-4">
                        <a href="{{ route('due.report') }}" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4">{{ my_currency($data['total_due']) }}</span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0">{{__('sell.total_due')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endcan
                    @can("Daftar Laporan Pengeluaran")
                    <div class="col-12 col-lg-6 col-xl">
                        <a href="{{ route('expense.report') }}" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4">{{ my_currency($data['total_expense']) }}</span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0">{{__('expense.total_expense')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endcan
                </div>

            </div>
            <div class="col-md-4 col-lx-4 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        @can("Daftar Laporan Pengeluaran")
                        <a href="{{ route('sell.report') }}" class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <span class="h4">{{ my_currency($data['total_sell']) }}</span>
                                        <h6 class="text-uppercase text-muted mt-2 m-0">{{__('sell.total_sell')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endcan
                        @can("Pengeluaran dan Pendapatan")
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header header-modal" style="height: 10px">
                                    <h5 class="card-title text-white" style="margin-top: -10px">Profit Vs Pengeluaran</h5>
                                </div>
                                <div class="card-body mt-2">
                                    <div id="incomeExpense" style="height:300px"></div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row">






            @can("POS")
            <a href="{{ route('pos.index') }}" class="col-6 col-lg-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-desktop"></i>
                                <h6 class="text-white font-semibold">{{__('general.pos')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
            @can("Daftar Penjualan")
            <a href="{{ route('sell.report') }}" class="col-6 col-lg-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-shopping-cart"></i>
                                <h6 class="text-white font-semibold">{{__('general.sell')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
            @can("Daftar Produk")
            <a href="{{ route('product.index') }}" class="col-6 col-lg-2">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-cubes"></i>
                                <h6 class="text-white font-semibold">{{__('sidebar.product')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
            @can("Daftar Purchase")
            <a href="{{ route('purchase.index') }}" class="col-6 col-lg-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-cart-plus"></i>
                                <h6 class="text-white font-semibold">{{__('sidebar.purchase')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
            @can("Laporan Hutang")
            <a href="{{ route('due.report') }}" class="col-6 col-lg-2">
                <div class="card bg-secondary">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-list"></i>
                                <h6 class="text-black font-semibold">{{__('sell.due')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
            @can("Daftar Pengeluaran")
            <a href="{{ route('expense.index') }}" class="col-6 col-lg-2">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12">
                                <i style="font-size: 20px;" class="fas fa-money-bill"></i>
                                <h6 class="text-white font-semibold">{{__('sidebar.expense')}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endcan
        </div>

        @can("Pengeluaran dan Pendapatan")
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-modal" style="height: 10px">
                        <h5 class="card-title text-white" style="margin-top: -10px">Transaksi</h5>
                    </div>
                    <div class="card-body mt-2">
                        <div id="transactiondata" style="height:350px"></div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
 
        @can("Aktivitas Terbaru")
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-modal" style="height: 10px">
                        <h5 class="card-title text-white" style="margin-top: -10px">{{__('general.new_activity')}}</h5>
                    </div>
                    <div class="card-body mt-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="sell-tab" data-bs-toggle="tab" href="#sell" role="tab" aria-controls="sell" aria-selected="true">{{__('general.sell')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="purchase-tab" data-bs-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false">{{__('sidebar.purchase')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="transfer-tab" data-bs-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="false">{{__('sidebar.r_stock_transfer')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="adjustment-tab" data-bs-toggle="tab" href="#adjustment" role="tab" aria-controls="adjustment" aria-selected="false">{{__('sidebar.stock_adjs')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="return-tab" data-bs-toggle="tab" href="#return" role="tab" aria-controls="return" aria-selected="false">{{__('sidebar.return')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="returnsell-tab" data-bs-toggle="tab" href="#returnsell" role="tab" aria-controls="returnsell" aria-selected="false">{{__('sell.return_sell')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="sell" role="tabpanel" aria-labelledby="sell-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__('general.ref_no')}}</th>
                                                <th>{{__('customer.name')}}</th>
                                                <th>{{__('purchase.net_total')}}</th>
                                                <th>{{__('general.payment_total')}}</th>
                                                <th>{{__('sell.due_total')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_sell'] as $as)
                                            <tr>
                                                <td> {{my_date($as->created_at)}}</td>
                                                <td>{{ $as->ref_no }}</td>
                                                <td>{{ $as->customer->name ?? '' }}</td>
                                                <td>{{ number_format($as->final_total) }}</td>
                                                <td>{{ $as->pay_total }}</td>
                                                <td>{{ number_format($as->due_total ?? $as->final_total) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__("general.date")}}</th>
                                                <th>{{__('general.ref_no')}}</th>
                                                <th>{{__('supplier.name')}}</th>
                                                <th>{{__('purchase.net_total')}}</th>
                                                <th>{{__('general.payment_total')}}</th>
                                                <th>{{__('general.po_due')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_purchase'] as $ap)
                                            <tr>
                                                <td>{{my_date($ap->created_at)}}</td>
                                                <td>{{ $ap->ref_no }}</td>
                                                <td>{{ $ap->supplier->name ?? '' }}</td>
                                                <td>{{ number_format($ap->final_total) }}</td>
                                                <td>{{ $ap->pay_total }}</td>
                                                <td>{{ number_format($ap->due_total ?? $ap->final_total) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__('general.ref_no')}}</th>
                                                <th>{{__('transfer.from')}}</th>
                                                <th>{{__('transfer.to')}}</th>
                                                <th>{{__('purchase.shipping_cost')}}</th>
                                                <th>{{__('purchase.net_total')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_stransfer'] as $at)
                                            <tr>
                                                <td>{{ my_date($at->created_at) }}</td>
                                                <td>{{ $at->ref_no }}</td>
                                                <td> {{ $at->transfer->fromstore->name ?? '' }} </td>
                                                <td> {{ $at->transfer->tostore->name ?? '' }} </td>
                                                <td>{{ number_format($at->shipping_charges) }}</td>
                                                <td>{{ number_format($at->final_total) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="adjustment" role="tabpanel" aria-labelledby="adjustment-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__('general.ref_no')}}</th>
                                                <th>{{__('purchase.net_total')}}</th>
                                                <th>{{__('adjustment.amount_recovered')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_sadjustment'] as $aa)
                                            <tr>
                                                <td>{{ my_date($aa->created_at) }}</td>
                                                <td>{{ $aa->ref_no }}</td>
                                                <td>{{ number_format($aa->final_total) }}</td>
                                                <td> {{ number_format($aa->total_amount_recovered) }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__("general.ref_no")}}</th>
                                                <th>{{__("purchase.parent_transaction")}}</th>
                                                <th>{{__('supplier.name')}}</th>
                                                <th>{{__('sell.total_return')}}</th>
                                                <th>{{__('general.total')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_return'] as $ar)
                                            <tr>
                                                <td> {{ my_date($ar->created_at) }}</td>
                                                <td> {{ $ar->ref_no }} </td>
                                                <td> {{ $ar->transaction->ref_no ?? '' }} </td>
                                                <td> {{ $ar->supplier->name ?? '' }} </td>
                                                <td> {{ $ar->qty_return }} Qty Return </td>
                                                <td> {{ number_format($ar->final_total) }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="returnsell" role="tabpanel" aria-labelledby="returnsell-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('general.date')}}</th>
                                                <th>{{__("general.ref_no")}}</th>
                                                <th>{{__("purchase.parent_transaction")}}</th>
                                                <th>{{__('customer.name')}}</th>
                                                <th>{{__('sell.total_return')}}</th>
                                                <th>{{__('general.total')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['act_returnsell'] as $rs)
                                            <tr>
                                                <td> {{ my_date($rs->created_at) }}</td>
                                                <td> {{ $rs->ref_no }} </td>
                                                <td> {{ $rs->transaction->ref_no ?? '' }} </td>
                                                <td> {{ $rs->customer->name ?? '' }} </td>
                                                <td> {{ count($rs->sellreturn) }} Qty Return </td>
                                                <td> {{ number_format($rs->final_total) }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan





    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendors/amcharts4/core.js') }}"></script>
<script src="{{ asset('assets/vendors/amcharts4/charts.js') }}"></script>
<script src="{{ asset('assets/vendors/amcharts4/animated.js') }}"></script>
<script src="{{ asset('assets/vendors/amcharts4/worldLow.js') }}"></script>
<script src="{{ asset('assets/vendors/amcharts4/maps.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>

<script src="{{ asset('assets/vendors/amcharts4/incomeexpense.js') }}"></script>
<script src="{{ asset('assets/vendors/amcharts4/transactiondata.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/sell_month.js') }}"></script>
@endsection