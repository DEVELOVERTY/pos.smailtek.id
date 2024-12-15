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
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="accordion" id="accordionSearching">
                        <div class="accordion-item border rounded mt-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#searchdata" aria-expanded="false" aria-controls="searchdata">
                                    <i class="fa fa-search" style="margin-right: 5px;"></i> {{__('general.search')}}
                                </button>
                            </h2>
                            <div id="searchdata" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSearching">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('store.choose_store')}}</label>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value="">{{__('store.choose_store')}}</option>
                                                    @foreach ($store as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['store'])) @if ($st->id==$_GET['store']) selected @endif @endif>{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('general.start_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('general.end_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-content" id="profitContent">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>{{__('sidebar.transaction_reports')}}</th>
                                                    <th class="text-right"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{__('report.total_purchase')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['total_purchase']->total ?? 0) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.total_sell')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['total_sell']->total ?? 0) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.shipping_purchase')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['purchase_shipping']) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.purchase_discount')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['purchase_discount']) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.sell_discount')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['sell_discount']) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.shipping_sell')}} </td>
                                                    <td class="text-right">: {{ my_currency($data['sell_shipping']) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.total_adjustment')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['stock_adjustment']->total ?? 0) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.total_recovered')}} </td>
                                                    <td class="text-right">: {{ my_currency($data['amount_recovered']) }} </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.total_expense')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['total_expense']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('report.shipping_transfer')}}</td>
                                                    <td class="text-right">: {{ my_currency($data['transfer_shipping']) }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>{{__('report.profitloss')}} </th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td> {{__('report.used_capital')}} </td>
                                                    <td class="text-right">: {{ my_currency($profitsell->modal) }}</td>
                                                    <td class="text-right">(-)</td>
                                                </tr>
                                                <tr>
                                                    <td> {{__('report.total_sell_after_po')}} </td>
                                                    <td class="text-right">: {{ my_currency($profitsell->terjual) }}</td>
                                                    <td class="text-right">(+)</td>
                                                </tr>
                                                <tr>
                                                    <td> {{__('report.total_return_after_po')}} </td>
                                                    <td class="text-right">: {{ my_currency($profitsell->dikembalikan) }}</td>
                                                    <td class="text-right">(-)</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:12px">{{__('report.total_adjustment')}} + {{__('report.total_expense')}} + {{__('report.shipping_purchase')}} + {{__('report.shipping_transfer')}} + {{__('report.sell_discount')}}</td>
                                                    @php
                                                    $adjustment = $data['stock_adjustment']->total ?? 0;
                                                    $jumlah = $adjustment + $data['total_expense'] + $data['purchase_shipping'] + $data['transfer_shipping'] + $data['sell_discount'];
                                                    @endphp
                                                    <td class="text-right">: {{ my_currency($jumlah) }}</td>
                                                    <td class="text-right">(-)</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:12px">{{__('report.shipping_sell')}} + {{__('report.total_recovered')}} + {{__('report.purchase_discount')}}</td>
                                                    @php
                                                    $jml = $data['sell_shipping'] + $data['amount_recovered'] + $data['purchase_discount'];
                                                    @endphp
                                                    <td class="text-right">: {{ my_currency($jml) }}</td>
                                                    <td class="text-right">(+)</td>
                                                </tr>
                                                @php
                                                $profiitbersih = ($profitsell->terjual - $profitsell->dikembalikan) - $jumlah + $jml;
                                                @endphp
                                                <tr style="background-color: #5cb85c;" class="text-white">
                                                    <td> {{__('report.net_profit')}} </td>
                                                    <td class="text-right">: {{ my_currency($profiitbersih) }}</td>
                                                    <td class="text-right"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    var start = null;
    var end = null;
    var store = null;

    function searchProduct() {
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var store = $("#store").val();
        var url = domainpath + '/pos-admin/report/transaction/profit-loss?start_date=' + start + '&end_date=' + end + '&store=' + store;
        spinner.show();
        setTimeout(function() {
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#profitContent').html(result);

                }
            });
            spinner.hide();
        }, 130);
    }
</script>
@endsection