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
                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <div class="input-group">
                                                    <select class="form-control select2" style="width: 100%;" id="customer" name="customer">
                                                        <option value="">{{__('report.choose_customer')}} </option>
                                                        @foreach ($customer as $s)
                                                        <option value="{{ $s->id }}" @if (isset($_GET['customer'])) @if ($s->id==$_GET['customer'])
                                                            selected @endif
                                                            @endif>{{ $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 mb-3">
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


                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <div class="input-group">
                                                    <select class="form-control" id="payment" name="payment">
                                                        <option value="">{{__('general.payment_status')}}</option>
                                                        @foreach ($payment as $p => $pay)
                                                        <option value="{{ $p }}">{{ $pay }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-md-4 mb-3">
                                                <label class="control-label">{{__('report.choose_kasir')}}</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="createdby" name="createdby">
                                                        <option value=""></option>
                                                        @foreach ($user as $u)
                                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
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
                        <div class="card-header header-modal">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                                </div>
                                <div class="col-6">
                                    @can("Download Laporan Penjualan")
                                    <a href="{{route('sell.download')}}" class="btn btn-sm btn-success float-end" style="margin-top: -13px; border: 2px solid white; margin-top: -5px"><i class="fas fa-download"></i> {{__("report.download_excel")}}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body" id="sellContent">
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
                                                <th>{{__('general.payment_status')}}</th>
                                                <th>{{__('report.product_sell')}}</th>
                                                <th>{{__('report.qty_sell')}}</th>
                                                <th>{{__('hrm.amount_total')}}</th>
                                                <th>{{__('general.pay_amount')}}</th>
                                                <th>{{__('general.payment_method')}}</th>
                                                <th>{{__('general.sell_due_amount')}}</th>
                                                <th>{{__('report.profit_amount')}}</th>
                                                <th>{{__('report.createdby')}}</th>
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
                                                                @can("Detail Penjualan")
                                                                <a class="dropdown-item" href="{{ route('sell.detail', $d->id) }}">
                                                                    <i class="fas fa-eye"></i> {{__('general.detail')}}
                                                                </a>
                                                                @endcan
                                                                @can("Print Penjualan")
                                                                <a target="_blank" class="dropdown-item" href="{{ route('sell.print', $d->id) }}">
                                                                    <i class="fas fa-print"></i> {{__('general.print')}}
                                                                </a>
                                                                @endcan
                                                                @can("Return Penjualan")
                                                                <a class="dropdown-item" href="{{ route('returnsell.create', $d->id) }}">
                                                                    <i class="fas fa-redo"></i> {{__('sell.return_sell')}}
                                                                </a>
                                                                @endcan
                                                                @can("Tambah Pembayaran Penjualan")
                                                                @if ($d->due_total != '0')
                                                                <a class="dropdown-item" href="javascript:void(0)" id="{{ $d->id }}" onclick="getpaymentmodal(this.id)">
                                                                    <i class="fas fa-money-bill-wave"></i> {{__('general.add_payment')}}
                                                                </a>
                                                                @endif
                                                                @endcan 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                                                <td> {{ $d->ref_no }} </td>
                                                <td> {{ $d->store->name ?? '' }} </td>
                                                <td> {{ $d->customer->name ?? '' }} </td>
                                                <td> <span class=" badge bg-primary text-white">{{$status[$d->status]}} </span> </td>
                                                <td> <span class=" badge bg-primary text-white">{{ count($d->sell) }}</span> </td>
                                                <td> <span class=" badge bg-primary text-white">{{ $d->qty_sell }}</span> {{$d->return_sell}}</td>
                                                <td> {{ number_format($d->final_total) }} </td>
                                                <td> {{ $d->pay_total }} </td>
                                                <td> {{ $d->method }} </td>
                                                <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>
                                                <td> {{ number_format($d->profit) }} </td>
                                                <td> {{ $d->createdby->name ?? '' }} </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                <th colspan="9" style="height: 100px; font-size:30px">{{__('report.total_income')}} : {{ number_format($jumlahProfit) }}</th>
                                                <th>{{ number_format($jumlahTotal) }}</th>
                                                <th></th>
                                                <th>{{ number_format($jumlahTerbayar) }}</th>
                                                <th>{{ number_format($jumlahHutang) }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    {{ $data->links('partials.purchase_pagination') }}
                                    @can("Tambah Pembayaran Penjualan")
                                    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
                                    @endcan
                                </div>
                                {{-- End Content --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
    </div>
    @can("Tambah Pembayaran Penjualan")
    <div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
            <form method="POST" action="{{ route('purchase.payment') }}" class="modal-content">
                @csrf
                <div class="modal-header header-modal ">
                    <input type="hidden" name="transaction_id" id="tri" value="">
                    <h5 class="modal-title text-white" id="">{{__('general.add_payment')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form form-horizontal">
                        <div class="form-body">
                            <div class="row" id="paymentsession">
                                <div class="col-md-6 form-group">
                                    <label>{{__('general.payment_method')}}</label>
                                    <select class="choices form-select" name="payment_method" id="payment_method">
                                        <option value="cash">Cash</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="card">Card</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>{{__('general.payment_date')}}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="2021-07-05 16:40" id="paid_date" name="paid_date" readonly="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row" id="paymentprocess">
                                        <div class="col-md-6 form-group">
                                            <label>{{__('general.payment_total')}}</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" value="0" id="payment_amount" name="payment_amount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>{{__('general.payment_note')}}</label>
                                    <textarea class="form-control" name="payment_note"></textarea>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{__('general.add_payment')}}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endcan
    @section('scripts')
    <script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(".select2").select2({
            width: 'resolve', 
        });

        function getstatusmodal(id) {
            $("#ti").val(id);
            document.getElementById("update_status").click();
        }

        function getpaymentmodal(id) {
            $("#tri").val(id);
            document.getElementById("add_payment").click();
        }

        function movePage(url) {
            spinner.show();
            setTimeout(function() {
                $("#sellContent").html("");
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#sellContent').html(result);
                    }
                });
                spinner.hide();
            }, 130)

        }
        var customer = null;
        var store = null;
        var status = null;
        var payment = null;
        var start = null;
        var end = null;

        function searchProduct() {
            var customer = $("#customer").val();
            var store = $("#store").val();
            var status = $("#status").val();
            var payment = $("#payment").val();
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var createdby = $("#createdby").val();
            var url = domainpath + '/pos-admin/report/transaction/sell?customer=' + customer + '&store=' + store + '&createdby=' + createdby + '&status=' + status +
                '&payment=' + payment + '&start_date=' + start + '&end_date=' + end;
            spinner.show();
            setTimeout(function() {
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#sellContent').html(result);

                    }
                });
                spinner.hide();
            }, 130);
        }

        function downloadReport()
        {
            
        }
    </script>
    @endsection
    @endsection