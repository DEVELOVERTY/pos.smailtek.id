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
                    @can("Tambah Stock Transfer")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('transfer.create') }}"><i class="fa fa-list"></i> {{__('sidebar.add_stock_transfer')}}</a>
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
                                        <div class="col-sm-12 col-md-6 mb-3">
                                            <label class="control-label">{{__('general.start_date')}}</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3">
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
                    <div class="card-content">
                        <div class="card-body">

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
                        <div class="card-body" id="transferContent">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.action')}}</th>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('general.ref_no')}}</th>
                                            <th>{{__('transfer.from')}}</th>
                                            <th>{{__('transfer.to')}}</th>
                                            <th>{{__('transfer.status')}}</th>
                                            <th>{{__('purchase.shipping_cost')}}</th>
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
                                                            @can("Detail Stock Transfer")
                                                            <a class="dropdown-item" href="{{ route('transfer.detail', $d->id) }}">
                                                                <i class="fas fa-eye"></i> {{__('general.detail')}}
                                                            </a>
                                                            @endif
                                                            @can("Update Status Stock Transfer")
                                                            @if ($d->status != 'complete')
                                                            <a class="dropdown-item po-edit" href="javascript:void(0)" id="{{ $d->id }}" onclick="getstatusmodal(this.id)">
                                                                <i class="fas fa-check-circle"></i> {{__('general.change_status')}}
                                                            </a>
                                                            @endif
                                                            @endcan
                                                            @can("Print Stock Transfer")
                                                            <a target="_blank" class="dropdown-item" href="{{ route('transfer.print', $d->id) }}">
                                                                <i class="fas fa-print"></i> {{__('general.print')}}
                                                            </a>
                                                            @endcan
                                                            <a class="dropdown-item" href="javascript:void(0)"> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{ my_date($d->created_at) }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                                            <td> {{ $d->ref_no }} </td>
                                            <td> {{ $d->transfer->fromstore->name ?? '' }} </td>
                                            <td> {{ $d->transfer->tostore->name ?? '' }} </td>
                                            <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> </td>
                                            <td> {{ number_format($d->shipping_charges) }} </td>
                                            <td> {{ number_format($d->final_total) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $data->links('partials.return_pagination') }}
                                <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
                            </div>
                            {{-- End Content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <form method="POST" action="{{ route('transfer.status') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="">{{__('general.change_status')}}</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="system_name">{{__('transfer.status')}}</label>
                            <input type="hidden" name="id" id="ti" value="">
                            <select class="form-control" name="status">
                                <option value="complete">{{__('transfer.complete')}}</option>
                                <option value="transit">{{__('transfer.transit')}}</option>
                                <option value="pending">{{__('transfer.pending')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i> <span class="d-none d-sm-block">{{ __('general.close') }}</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i> <span class="d-none d-sm-block">{{ __('general.change_status') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @section('scripts')
        <script src="{{ asset('assets/vendors/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/datatables/datatables.js') }}"></script>
        <script>
            function getstatusmodal(id) {
                $("#ti").val(id);
                document.getElementById("update_status").click();
            }

            function getpaymentmodal(id) {
                $("#tri").val(id);
                document.getElementById("add_payment").click();
            }

            function movePage(url) {

                $("#transferContent").html("s");
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#transferContent').html(result);
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
                var url = domainpath + '/pos-admin/stock-transfer/index?start_date=' + start + '&end_date=' + end + '';
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#transferContent').html(result);

                    }
                });
            }
        </script>
        @endsection
        @endsection