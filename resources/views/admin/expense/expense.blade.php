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
                    @can("Tambah Pengeluaran")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('expense.create') }}"><i class="fa fa-plus"></i> {{ __('sidebar.add_expense') }}</a>
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

                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label">{{__('sidebar.category')}}</label>
                                            <div class="input-group">
                                                <select class="form-control" id="category" name="category">
                                                    <option value="">{{__('category.choose_category')}}</option>
                                                    @foreach ($category as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['category'])) @if ($st->id==$_GET['category']) selected @endif @endif>{{ $st->name }}</option>
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
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="expenseContent">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('general.ref_no')}}</th>
                                            <th>{{__('general.category_name')}}</th>
                                            <th>{{__('expense.name')}}</th>
                                            <th>{{__('expense.amount')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('general.date')}}</th>
                                            <th>{{__('general.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $d)
                                        <tr>
                                            <td> {{ $d->ref_no }} </td>
                                            <td> {{ $d->category->name ?? '' }} </td>
                                            <td> {{ $d->name }} </td>
                                            <td> {{ number_format($d->amount) }} </td>
                                            <td> {{ $d->store->name ?? '' }} </td>
                                            <td> {{ my_date($d->created_at) }} </td>
                                            <td>
                                                @can("Update Pengeluaran")
                                                <a href="{{ route('expense.update',$d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                @endcan
                                                @can("Detail Pengeluaran")
                                                <a href="{{ route('expense.detail',$d->id) }}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                                @endcan
                                                @can("Hapus Pengeluaran")
                                                <a href="{{ route('expense.delete',$d->id) }}" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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

        $("#expenseContent").html("s");
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#expenseContent').html(result);
            }
        });
    }
    var category = null;
    var start = null;
    var end = null;

    function searchProduct() {
        var category = $("#category").val();

        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/expense/index?category=' + category + '&start_date=' + start + '&end_date=' + end + '';
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#expenseContent').html(result);

            }
        });
    }
</script>
@endsection
@endsection