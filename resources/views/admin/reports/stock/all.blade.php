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
                                        <div class="col-sm-12 col-md-6 mb-6">
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


                                        <div class="col-sm-12 col-md-6 mb-6">
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <input class="form-control" name="name" id="name" placeholder="{{__('produk.name')}} / {{__('produk.variant_name')}} ">
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
            </div>

            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="productstock">
                            {{-- Content Product --}}
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>{{__('produk.name')}}</th>
                                            <th>{{__('general.store')}}</th>
                                            <th>{{__('report.total_stock')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($data as $d)
                                        <tr class="purchase_order">
                                            <td>{{$no++}}</td>
                                            <td> {{ $d->product_name }} - {{$d->variation_name}} </td>
                                            <td> {{ $d->store_name}} </td>
                                            <td> {{ number_format($d->stok) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                {{ $data->links('partials.purchase_pagination') }}
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
<script>
    function movePage(url) {
        spinner.show();
        setTimeout(function() {
            $("#productstock").html("");
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#productstock').html(result);
                }
            });
            spinner.hide();
        }, 130)

    }
    var name = null;
    var store = null;

    function searchProduct() {
        var name = $("#name").val();
        var store = $("#store").val();
        var url = domainpath + '/pos-admin/report/stock-product/all-stock?name=' + name + '&store=' + store;
        spinner.show();
        setTimeout(function() {
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#productstock').html(result);

                }
            });
            spinner.hide();
        }, 130);
    }
</script>
@endsection
@endsection