@extends('layouts.admin')
@section('content')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/select3/dist/css/select2.min.css') }}" />
@endsection
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
                                        <div class="col-sm-6 col-md-3 mb-3">
                                            <label class="control-label">{{__('report.choose_customer')}}</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="customer" name="customer">
                                                    <option value="">{{__('report.choose_customer')}} </option>
                                                    @foreach ($customer as $s)
                                                    <option value="{{ $s->id }}" @if (isset($_GET['customer'])) @if ($s->id==$_GET['customer'])
                                                        selected @endif
                                                        @endif>{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">{{__('store.choose_store')}}</label>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value="">{{__('store.choose_store')}}</option>
                                                    @foreach ($store as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['store'])) @if ($st->id==$_GET['store']) selected @endif
                                                        @endif>{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">{{__('general.start_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 mb-3">
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
                    <div class="card-header header-modal">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                            </div>
                            <div class="col-6">
                                @can("Download Laporan Hutang")
                                <a href="{{route('due.download')}}" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i> {{__("report.download_excel")}} </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="dueContent">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.action')}}</th>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('general.ref_no')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('customer.name')}}</th>
                                            <th>{{__('hrm.amount_total')}}</th>
                                            <th>{{__('general.pay_amount')}}</th>
                                            <th>{{__('general.sell_due_amount')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $d)
                                        <tr class="purchase_order">
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-error-circle me-50"></i> {{__('general.action')}}
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                                            @can("Detail Hutang")
                                                            <a class="dropdown-item" href="{{ route('due.detail', $d->id) }}">
                                                                <i class="fas fa-eye"></i> {{__('general.detail')}}
                                                            </a>
                                                            @endcan
                                                            @can("Print Laporan Hutang")
                                                            <a target="_blank" class="dropdown-item" href="{{ route('due.print', $d->id) }}">
                                                                <i class="fas fa-print"></i> {{__('general.print')}}
                                                            </a>
                                                            @endcan
                                                            @can("List Credit Hutang")
                                                            <a class="dropdown-item" href="{{ route('due.payment', $d->id) }}">
                                                                <i class="fas fa-money-bill"></i>{{__('report.payment_list')}}
                                                            </a>
                                                            @endcan
                                                            <a class="dropdown-item" href="#"> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                                            <td> {{ $d->ref_no }} </td>
                                            <td> {{ $d->store->name ?? '' }} </td>
                                            <td> {{ $d->customer->name ?? '' }} </td>
                                            <td> {{ number_format($d->final_total) }} </td>
                                            <td> {{ $d->pay_total }} </td>
                                            <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="5" style="height: 100px; font-size:30px">{{__('general.total')}}</th>
                                            <th>{{ number_format($jumlahTotal) }}</th>
                                            <th>{{ number_format($jumlahTerbayar) }}</th>
                                            <th>{{ number_format($jumlahHutang) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{ $data->links('partials.purchase_pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
<script>
    $(".select2").select2({
        width: 'resolve' // need to override the changed default
    });



    function movePage(url) {
        spinner.show();
        setTimeout(function() {
            $("#dueContent").html("s");
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#dueContent').html(result);
                }
            });
            spinner.hide();
        }, 130)

    }
    var customer = null;
    var store = null;
    var status = null;
    var start = null;
    var end = null;

    function searchProduct() {
        var customer = $("#customer").val();
        var store = $("#store").val();
        var status = $("#status").val();
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/report/transaction/due?customer=' + customer + '&store=' + store + '&status=' + status +
            '&start_date=' + start + '&end_date=' + end + '';
        spinner.show();
        setTimeout(function() {
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#dueContent').html(result);

                }
            });
            spinner.hide();
        }, 130);
    }
</script>
@endsection
@endsection