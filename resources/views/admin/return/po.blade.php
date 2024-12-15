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
                    @can("Daftar Purchase")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('purchase.index') }}"><i class="fa fa-list"></i> {{ __('sidebar.purchase') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>
 
            <div class="row match-height">
                <form id="" method="POST" action="{{ route('return.store') }}" enctype="multipart/form-data" class="col-md-12 col-12">
                    @csrf

                    <div class="card ">
                        <div class="card-header header-modal" >
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
                                                    <input type="hidden" name="transaction_id" value="{{ $data->id }}">
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
                                                                    <td>{{__('purchase.quantity')}}</td>
                                                                    <td>{{__('purchase.return_have')}}</td>
                                                                    <td>{{__('purchase.unit_cost')}} </td>
                                                                    <td>{{__('purchase.return_qty')}}</td>
                                                                    <td width="10%">{{__('purchase.return_subtotal')}}</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="defaulth">
                                                                @foreach ($data->purchase as $p)
                                                                <tr>
                                                                    <td>{{ $p->product->name }} - {{ $p->variation->name }}</td>
                                                                    <td>{{ $p->quantity }}</td>
                                                                    <td>{{ $p->quantity_remaining($p->id) }} </td>
                                                                    <td>{{ number_format($p->purchase_price) }}</td>
                                                                    <td width="15%">
                                                                        <input type="hidden" name="p_id[]" value="{{ $p->id }}">
                                                                        <input type="hidden" id="purchaseprice{{ $p->id }}" value="{{ $p->purchase_price }}">
                                                                        <input type="number" class="form-control qty_return" name="qty_return[]" id="{{ $p->id }}" min="0" max="{{ $p->quantity_remaining($p->id) }}" value="0">
                                                                        <span class="error-{{ $p->id }} d-none" style="color: red;">* {{__('purchase.max_qty')}}</span>
                                                                    </td>
                                                                    <td width="10%">
                                                                        <input type="text" name="subtotal_return[]" class="form-control subtotalreturn" id="subtotal{{ $p->id }}" value="0" readonly>
                                                                    </td>
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <hr style="border: 1px solid black;">
                                                    <button class="btn btn-primary" type="submit">{{__('general.create')}}</button>
                                                    <h5 class="float-end">{{__('purchase.items_total')}}: <span id="items_total"></span> </h5>
                                                    <input type="hidden" name="items_total" id="total_items">
                                                    <br><br>
                                                    <h5 class="float-end" style="margin-top: -20px">{{__('purchase.net_total')}}: <span id="amount_total"></span> </h5>
                                                    <input type="hidden" name="amount_total" id="total_amount">
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
        $("#defaulth").on("change", ".qty_return", function(e) {
            var value = e.target.value;
            var max = e.target.max;
            var price = $("#purchaseprice" + e.target.id).val();
            var sbtl = parseInt(price) * parseInt(value);
            $("#subtotal" + e.target.id).val(formatRupiah(sbtl.toString()));

            if (parseInt(value) > parseInt(max)) {
                $(".error-" + e.target.id).removeClass("d-none");
                $("#" + e.target.id).val(max);

                var sbtl = parseInt(price) * parseInt(max);
                $("#subtotal" + e.target.id).val(formatRupiah(sbtl.toString()));
                return false;
            } else {
                $(".error-" + e.target.id).addClass("d-none");
            }
        });

        $(".po_items").on("change", function() {
            var totalItems = 0;
            var totalAmount = 0;
            $(this).find('input.qty_return').each(function() {
                totalItems += parseInt($(this).val());
            });
            $(this).find('input.subtotalreturn').each(function() {
                totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
            });
            $("#items_total").html(totalItems);
            $("#total_items").val(totalItems);
            $("#amount_total").html(formatRupiah(totalAmount.toString()));
            $("#total_amount").val(totalAmount);
        });
    </script>
    @endsection
    @endsection