@extends('layouts.admin')
@section('content')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css') }}">
<link href="{{ asset('assets/vendors/summernote/summernote.min.css') }}" rel="stylesheet">
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
                    @can("Daftar Produk")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('product.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.product') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <form id="" method="POST" action="{{ route('store.opening','create') }}" enctype="multipart/form-data" class="col-md-12 col-12">
                @csrf 
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="control-label">{{__('general.ref_no')}}</label>
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="product_id" value="{{ $data->id }}">
                                                <input type="text" class="form-control" value="{{ old('ref_no') }}" id="product_sku" name="ref_no">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="table-responsive po_items">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table-1">
                                                        <thead>
                                                            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                                <td>{{__('produk.name')}}</td>
                                                                <td>{{__('purchase.quantity')}} - {{__('produk.open_stock')}} </td>
                                                                <td>{{__('general.purchase_price')}} </td>
                                                                <td width="10%">{{__('general.subtotal')}}</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="defaulth">
                                                            @php
                                                            $subtotal = 0;
                                                            @endphp
                                                            @foreach ($data->variant as $v)
                                                            @php
                                                            $subtotal += $v->purchase_price;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $v->product->name ?? ''}} - {{ $v->name }}</td>
                                                                <td>
                                                                    <input type="hidden" name="variation_id[]" id="variationID" value="{{$v->id}}">
                                                                    <input type="number" class="form-control qty_opening" name="qty_opening[]" id="{{ $v->id }}" min="1" value="1">
                                                                </td>
                                                                <td>{{number_format($v->purchase_price)}}</td>
                                                                <td width="15%">
                                                                    <input type="hidden" id="pricing-{{$v->id}}" name="pricing[]" value="{{$v->purchase_price}}">
                                                                    <input type="text" name="opening_subtotal[]" class="form-control opening_subtotal" id="subtotal{{ $v->id }}" value="{{number_format($v->purchase_price)}}" readonly>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr style="border: 1px solid black;">
                                                <button class="btn btn-primary" type="submit">{{__('produk.add_stok')}}</button>
                                                <h5 class="float-end">{{__('purchase.items_total')}}: <span id="items_total">{{count($data->variant)}}</span> </h5>
                                                <br><br>
                                                <h5 class="float-end" style="margin-top: -20px">{{__('purchase.net_total')}}: <span id="amount_total"> {{number_format($subtotal)}} </span> </h5>
                                                <input type="hidden" name="amount_total" id="total_amount" value="{{$subtotal}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $("#defaulth").on("change", ".qty_opening", function(e) {
        var value = e.target.value;
        var id = e.target.id;
        var price = $("#pricing-" + id).val();
        var sbtl = parseInt(price) * parseInt(value);
        console.log(value, price, sbtl)
        $("#subtotal" + id).val(formatRupiah(sbtl.toString()));
    });

    $(".po_items").on("change", function() {
        var totalItems = 0;
        var totalAmount = 0;
        $(this).find('input.qty_opening').each(function() {
            totalItems += parseInt($(this).val());
        });
        $(this).find('input.opening_subtotal').each(function() {
            totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
        });
        $("#items_total").html(totalItems);
        $("#amount_total").html(formatRupiah(totalAmount.toString()));
        $("#total_amount").val(totalAmount);
    });
</script>
@endsection
@endsection