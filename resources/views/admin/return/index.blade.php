@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
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
                                            <label class="control-label">{{__('general.store')}}</label>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value="">{{__('general.choose_store')}}</option>
                                                    @foreach ($store as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['store'])) @if ($st->id==$_GET['store']) selected @endif
                                                        @endif>{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('general.start_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" placeholder="{{__('general.start_date')}}" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('general.end_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" id="end_date" placeholder="{{__('general.end_date')}}" class="form-control" value="{{ old('end_date') }}">
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
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="returnContent">
                            <div class="table-responsive">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.action')}}</th>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('general.ref_no')}}</th>
                                            <th>{{__('purchase.parent_transaction')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('sidebar.supplier')}}</th>
                                            <th>{{__('sell.total_return')}}</th>
                                            <th>{{__('general.total')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $d)
                                        <tr>
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-error-circle me-50"></i> {{__('general.action')}}
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                                            @can("Detail Return")
                                                            <a class="dropdown-item" href="{{ route('return.detail', $d->id) }}">
                                                                <i class="fas fa-eye"></i> {{__('general.detail')}}
                                                            </a>
                                                            @endcan
                                                            @can("Print Return")
                                                            <a target="_blank" class="dropdown-item" href="{{ route('return.print', $d->id) }}">
                                                                <i class="fas fa-print"></i> {{__('general.print')}}
                                                            </a>
                                                            @endcan
                                                            @can("Tambah Pembayaran Return")
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
                                            <td> {{ $d->transaction->ref_no ?? '' }} </td>
                                            <td> {{ $d->store->name ?? '' }} </td>
                                            <td> {{ $d->supplier->name ?? '' }} </td>
                                            <td> {{ $d->qty_return }} Qty Return </td>
                                            <td> {{ number_format($d->final_total) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $data->links('partials.return_pagination') }}
                                @can("Tambah Pembayaran Return")
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
</div>

@can("Tambah Pembayaran Return")
<div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
        <form method="POST" action="{{ route('purchase.payment') }}" class="modal-content">
            @csrf
            <div class="modal-header header-modal">
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
                                    <input type="text" class="form-control" value="{{date("Y-m-d H:i:s")}}" id="paid_date" name="paid_date" readonly="">
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
                    <span class="d-none d-sm-block">{{ __('general.add_payment') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan

@section('scripts')
<script src="{{ asset('assets/vendors/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/datatables.js') }}"></script>
<script>
    function getpaymentmodal(id) {
        $("#tri").val(id);
        document.getElementById("add_payment").click();
    }

    function movePage(url) {

        $("#returnContent").html("s");
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#returnContent').html(result);
            }
        });
    }
    var supplier = null;
    var store = null;
    var status = null;
    var payment = null;
    var start = null;
    var end = null;

    function searchProduct() {
        var store = $("#store").val();
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/return/index?store=' + store + '&start_date=' + start + '&end_date=' + end + '';
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#returnContent').html(result);

            }
        });
    }
</script>
@endsection
@endsection