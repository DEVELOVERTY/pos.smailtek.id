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
                    @can("Tambah Produk")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('product.create') }}">
                        <i class="fa fa-plus"></i> {{ __('sidebar.add_product') }}
                    </a>
                    <a class="btn btn-md btn-success float-end me-2" href="{{ route('product.export') }}">
                        <i class="fa fa-file-excel"></i> Export Product
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component> 
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card ">
                        <div class="card-header header-modal">
                            <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body" id="product-content">
                                {{-- Content Product --}}

                                <div class="table-responsive">
                                    <div class="float-end mb-5">
                                        <form method="get" class="row">
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <select class="form-control" id="unit">
                                                        <option value="">{{__('produk.choose_unit')}}</option>
                                                        @foreach ($unit as $u)
                                                        <option value="{{ $u->id }}" @if (isset($_GET['unit'])) @if ($u->id==$_GET['unit']) selected @endif
                                                            @endif>{{ $u->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <select class="form-control" id="brand">
                                                        <option value="">{{__('produk.choose_brand')}}</option>
                                                        @foreach ($brand as $b)
                                                        <option value="{{ $b->id }}" @if (isset($_GET['brand'])) @if ($b->id==$_GET['brand']) selected @endif
                                                            @endif>{{ $b->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="name" placeholder="{{__('produk.name')}}" value="@if (isset($_GET['name'])) {{ $_GET['name'] }} @endif">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> No </th>
                                                <th>ID</th>
                                                <th>{{ __('general.image') }}</th>
                                                <th>{{ __('produk.name') }}</th>
                                                <th>{{ __('category.category_name') }}</th>
                                                <th>{{ __('general.sell_price') }}</th>
                                                <th>{{ __('general.purchase_price') }}</th>
                                                <th>{{ __('sidebar.unit') }}</th>
                                                <th>{{ __('sidebar.brand') }}</th>
                                                <th>{{ __('general.stock') }}</th>
                                                <th>{{ __('general.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no = 1;
                                            @endphp
                                            @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $no++ }} </td>
                                                <td> {{ $d->id }} </td>
                                                <td>
                                                    <img src="{{ asset($d->image) }}" style="width: 50px; border-radius: 10%">
                                                </td>
                                               
                                                <td> {{ $d->name }} </td>
                                                <td> {{ $d->category->name ?? '' }} </td>
                                                <td> {{ $d->price_sell_range }} </td>
                                                <td> {{ $d->price_purchase_range }} </td>
                                                <td> {{ $d->unit->name ?? '' }} </td>
                                                <td> {{ $d->brand->name ?? '' }} </td>
                                                <td> {{$d->stock_total}} </td>
                                                <td>
                                                    @can("Update Produk")
                                                    <a href="{{ route('product.update', $d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('product.opening', $d->id) }}" class="btn btn-sm btn-success"><i class="fa fa-cubes"></i> {{__('produk.open_stock')}}</a>
                                                    @endcan
                                                    @can("Hapus Produk")
                                                    <a href="{{ route('product.delete', $d->id) }}" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{ $data->links('partials.product_pagination') }}
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
            $("#product-content").html("");
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#product-content').html(result);
                }
            });
        }
        var name = null;
        var brand = null;
        var unit = null;
        var supplier = null;

        function searchProduct() {
            var name = $("#name").val();
            var brand = $("#brand").val();
            var unit = $("#unit").val();
            var supplier = $("#supplier").val();
            console.log(supplier);
            $("#product-content").html("");
            $.ajax({
                url: domainpath + '/pos-admin/product?unit=' + unit + '&supplier=' + supplier + '&brand=' + brand + '&name=' + name + '',
                dataType: "html",
                success: function(result) {
                    $('#product-content').html(result);
                }
            });
        }
    </script>
    @endsection
    @endsection