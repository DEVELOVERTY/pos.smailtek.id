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
                                @can("Download Stock Transfer")
                                <a href="{{route('transfer.download')}}" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i> {{__('report.download_excel')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="transferContent">
                            {{-- Content Product --}}

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('transfer.from')}}</th>
                                            <th>{{__('transfer.to')}}</th>
                                            <th>{{__('transfer.status')}}</th>
                                            <th>{{__('purchase.shipping_cost')}}</th>
                                            <th>{{__('report.qty_product')}}</th>
                                            <th>{{__('general.total')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                        <tr>
                                            <td> {{ $d->created_at }} <input type="hidden" id="idpo" value="{{ $d->id }}"></td>
                                            <td> {{ $d->transfer->fromstore->name ?? '' }} </td>
                                            <td> {{ $d->transfer->tostore->name ?? '' }} </td>
                                            <td> <span class=" badge bg-primary text-white">{{ $status[$d->status] }}</span> </td>
                                            <td> {{ number_format($d->shipping_charges) }} </td>
                                            <td> <span class=" badge bg-primary text-white">{{ count($d->manytransfer) }} Product</span> <span class=" badge bg-primary text-white">{{ $d->transfer_qty }} Quantity</span> </td>
                                            <td> {{ number_format($d->final_total) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="6" style="height: 100px; font-size:30px">{{__('general.total')}}</th>
                                            <th> {{ my_currency($jumlah) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                {{ $data->links('partials.return_pagination') }}
                            </div>
                            {{-- End Content --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{ asset('assets/vendors/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/datatables.js') }}"></script>
<script>
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
    var start = null;
    var end = null;

    function searchProduct() {
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/report/stock-product/transfer?start_date=' + start + '&end_date=' + end + '';
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