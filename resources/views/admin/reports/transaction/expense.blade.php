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

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Filter Toko</label>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value="">Pilih Toko</option>
                                                    @foreach ($store as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['store'])) @if ($st->id==$_GET['store']) selected @endif
                                                        @endif>{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Filter Kategori</label>
                                            <div class="input-group">
                                                <select class="form-control" id="category" name="category">
                                                    <option value="">Pilih category</option>
                                                    @foreach ($category as $st)
                                                    <option value="{{ $st->id }}" @if (isset($_GET['category'])) @if ($st->id==$_GET['category']) selected @endif
                                                        @endif>{{ $st->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Mulai Tanggal</label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" placeholder="Mulai Tanggal" class="form-control" value="{{ old('start_date') }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="control-label">Sampai Tanggal</label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" id="end_date" placeholder="Sampai Tanggal" class="form-control" value="{{ old('end_date') }}">
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
                                @can("Download Laporan Pengeluaran")
                                <a href="#" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i>
                                    Download Excel</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="expenseContent">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref No</th>
                                            <th>Kategori</th>
                                            <th>Nama Pengeluaran</th>
                                            <th>Store</th>
                                            <th>Tanggal</th>
                                            <th>Refund</th>
                                            <th>Jumlah Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                        <tr>
                                            <td> {{ $d->ref_no }} </td>
                                            <td> {{ $d->category->name ?? '' }} </td>
                                            <td> {{ $d->name }} </td>
                                            <td> {{ $d->store->name ?? '' }} </td>
                                            <td> {{ my_date($d->created_at) }} </td>
                                            <td>
                                                @if($d->refund == 'yes')
                                                Iya
                                                @else
                                                Bukan
                                                @endif
                                            </td>
                                            <td> {{ number_format($d->amount) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="6" style="height: 100px; font-size:30px">Total</th>
                                            <th>{{ number_format($jumlahTotal) }}</th>
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
        </section>

    </div>


    @section('scripts')
    <script>
        function movePage(url) {

            $("#expenseContent").html("s");
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
        var category = null;
        var start = null;
        var end = null;
        var store = null;

        function searchProduct() {
            var category = $("#category").val();
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var store = $("#store").val();
            var url = domainpath + '/pos-admin/report/transaction/expense?category=' + category + '&start_date=' + start + '&end_date=' + end + '&store=' + store;
            spinner.show();
            setTimeout(function() {
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#expenseContent').html(result);

                    }
                });
                spinner.hide();
            }, 130);
        }
    </script>
    @endsection
    @endsection