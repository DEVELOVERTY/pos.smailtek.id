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
                    @can("Tambah Purchase")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('purchase.create') }}"><i class="fa fa-plus"></i> {{ __('sidebar.add_purchase') }}</a>
                    @endcan
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
                                        <div class="col-sm-6 col-md-4 mb-4">
                                            <div class="input-group">
                                                <select class="form-control" id="supplier" name="supplier">
                                                    <option value="">{{__('general.choose_supplier')}}</option>
                                                    @foreach ($supplier as $s)
                                                    <option value="{{ $s->id }}" @if (isset($_GET['supplier'])) @if ($s->id==$_GET['supplier'])
                                                        selected @endif
                                                        @endif>{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-4">
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

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <div class="input-group">
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">{{__('purchase.received_status')}}</option>
                                                    <option value="received">{{__('purchase.received')}}</option>
                                                    <option value="pending">{{__('purchase.pending')}}</option>
                                                    <option value="ordered">{{__('purchase.ordered')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <label class="control-label">{{__('general.payment_status')}}</label>
                                            <div class="input-group">
                                                <select class="form-control" id="payment" name="payment">
                                                    <option value="">{{__('general.payment_status')}}</option>
                                                    <option value="due">{{__('general.po_due')}}</option>
                                                    <option value="paid">{{__('general.paid')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <label class="control-label">{{__('general.start_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" placeholder="Mulai Tanggal" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
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
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="purchaseContent">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.action')}}</th>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('general.ref_no')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('supplier.name')}}</th>
                                            <th>{{__('purchase.received_status')}}</th>
                                            <th>{{__('general.payment_status')}}</th>
                                            <th>{{__('general.pay_amount')}}</th>
                                            <th>{{__('general.po_due_amount')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $d)
                                        <tr class="purchase_order">
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="bi bi-error-circle me-50"></i> Action </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                                            @can("Detail Purchase")
                                                            <a class="dropdown-item" href="{{ route('purchase.detail', $d->id) }}">
                                                                <i class="fas fa-eye"></i> {{__('general.detail')}}
                                                            </a>
                                                            @endcan
                                                            @can("Print Purchase")
                                                            <a target="_blank" class="dropdown-item" href="{{ route('purchase.print', $d->id) }}">
                                                                <i class="fas fa-print"></i> {{__('general.print')}}
                                                            </a>
                                                            @endcan
                                                            @if ($d->status != 'received')
                                                            @can("Update Status Purchase")
                                                            <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatusmodal(this.id)">
                                                                <i class="fas fa-check-circle"></i> {{__('general.change_status')}}
                                                            </a>
                                                            @endcan
                                                            @endif
                                                            @if($d->payment_status == 'due')
                                                            @if($d->due_total < $d->pay_total)
                                                                @can("Update Status Purchase")
                                                                <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatuspayment(this.id)">
                                                                    <i class="fas fa-money-bill-wave"></i> {{__('purchase.change_payment_status')}}
                                                                </a>
                                                                @endcan
                                                                @endif
                                                                @endif
                                                                @if ($d->due_total != '0')
                                                                @can("Tambah Pembayaran Purchase")
                                                                <a class="dropdown-item" href="javascript:void(0)" id="{{ $d->id }}" onclick="getpaymentmodal(this.id)">
                                                                    <i class="fas fa-money-bill-wave"></i> {{__('general.add_payment')}}
                                                                </a>
                                                                @endcan
                                                                @endif
                                                                @can("Produk Label")
                                                                <a class="dropdown-item" href="{{ route('barcode.purchase',$d->id) }}">
                                                                    <i class="fas fa-barcode"></i> {{__('produk.print_label')}}
                                                                </a>
                                                                @endcan
                                                                @can("Tambah Return")
                                                                @if($d->status == 'received')
                                                                <a class="dropdown-item" href="{{ route('return.po',$d->id) }}">
                                                                    <i class="fas fa-redo"></i> {{__('purchase.return')}}
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
                                            <td> {{ $d->supplier->name ?? '' }} </td>
                                            <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> {{ $d->return }}</td>
                                            <td> <span class=" badge bg-primary text-white">{{ $payment[$d->payment_status] }}</span> </td>
                                            <td> {{ $d->pay_total }} </td>
                                            <td> {{ number_format($d->due_total ?? $d->final_total) }} </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $data->links('partials.purchase_pagination') }}
                                @can('Update Status Purchase')
                                <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
                                <a href="javascript:void(0)" class="d-none" id="update_payment" data-bs-toggle="modal" data-bs-target="#updatepayment"></a>
                                @endcan
                                @can('Tambah Pembayaran Purchase')
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
@can("Update Status Purchase")
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{ route('purchase.status') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="">{{__('general.change_status')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name">{{__('purchase.received_status')}}</label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="received">{{__('purchase.received')}}</option>
                        <option value="order">{{__('purchase.ordered')}}</option>
                        <option value="pending">{{__('purchase.pending')}}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.save') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="updatepayment" tabindex="-1" role="dialog" aria-labelledby="update-payment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="{{ route('purchase.payment_status') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="">{{__('purchase.change_payment_status')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name">{{__('general.payment_status')}}</label>
                    <input type="hidden" name="id" id="up" value="">
                    <select class="form-control" name="payment_status">
                        <option value="paid">{{__('general.paid')}}</option>
                        <option value="due">{{__('general.po_due')}}</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('general.save') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endcan
@can("Tambah Pembayaran Purchase")
<div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
        <form method="POST" action="{{ route('purchase.payment') }}" class="modal-content">
            @csrf
            <div class="modal-header header-modal ">
                <input type="hidden" name="transaction_id" id="tri" value="">
                <h5 class="modal-title text-white" id="">{{__('general.add_payment')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
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
                    <span class="d-none d-sm-block">{{__('general.add_payment')}}</span>
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
    function getstatusmodal(id) {
        $("#ti").val(id);
        document.getElementById("update_status").click();
    }

    function getstatuspayment(id) {
        $("#up").val(id);
        document.getElementById("update_payment").click();
    }

    function getpaymentmodal(id) {
        $("#tri").val(id);
        document.getElementById("add_payment").click();
    }

    function movePage(url) {

        $("#purchaseContent").html("s");
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#purchaseContent').html(result);
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
        var supplier = $("#supplier").val();
        var store = $("#store").val();
        var status = $("#status").val();
        var payment = $("#payment").val();
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/purchase/index?supplier=' + supplier + '&store=' + store + '&status=' + status +
            '&payment=' + payment + '&start_date=' + start + '&end_date=' + end + '';
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#purchaseContent').html(result);

            }
        });
    }
</script>
@endsection
@endsection