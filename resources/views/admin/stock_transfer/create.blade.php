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
                    @can("Daftar Stock Transfer")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('transfer.index') }}"><i class="fa fa-list"></i> {{__('sidebar.stock_transfer')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <form id="" method="POST" action="{{ route('transfer.store') }}" enctype="multipart/form-data" class="col-md-12 col-12">
                @csrf
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.ref_no') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('ref_no') }}" id="product_sku" name="ref_no">
                                                <button class="btn btn-outline-secondary" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.date')}} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('transaction_date', date('Y-m-d H:i')) }}" id="transaction_date" name="transaction_date" readonly>
                                                <button class="btn btn-outline-secondary" type="button" id="transaction_date"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('transfer.status') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="status" id="sts">
                                                <option value="">{{ __('general.choose_status') }}</option>
                                                @foreach ($status as $s => $values)
                                                <option value="{{ $s }}" @if ($s==old('status')) selected @endif>{{ $values }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('transfer.from')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="from" id="from">
                                                @foreach ($store as $st)
                                                @if(Session::get('mystore') == $st->id)
                                                <option value="{{ $st->id }}" @if ($st->id == old('from')) selected @endif>{{ $st->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('transfer.to')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="to" id="to">
                                                <option value="">{{__('transfer.choose_store')}}</option>
                                                @foreach ($store as $st)
                                                @if(Session::get('mystore') != $st->id)
                                                <option value="{{ $st->id }}" @if ($st->id == old('from')) selected @endif>{{ $st->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="table-responsive po_items">
                                            <div class="content-center">
                                                <div class="input-group mb-3">
                                                    <select id='selProduct' required name='getProduct' class='form-control' style='width: 100%;' readonly>
                                                        <option value=''>{{ __('produk.choose_product') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="table-1">
                                                    <thead>
                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                            <td>{{__('produk.name')}}</td>
                                                            <td>{{ __('purchase.quantity') }}</td>
                                                            <td>{{__('purchase.unit_cost')}}</td>
                                                            <td>{{__('general.subtotal')}}</td>
                                                            <td><i class="fa fa-trash"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="defaulth">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr style="border: 1px solid black;">
                                            <h5 class="float-end">{{__('purchase.items_total')}} : <span id="items_total"></span> </h5>
                                            <input type="hidden" name="items_total" id="total_items">
                                            <br><br>
                                            <h5 class="float-end" style="margin-top: -20px">{{__('purchase.net_total')}} : <span id="amount_total"></span> </h5>
                                            <input type="hidden" name="amount_total" id="total_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card discount_card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.shipping_detail')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('shipping_details') }}" id="shipping_details" name="shipping_details">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>{{__('purchase.shipping_cost')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('shipping_charges', 0) }}" id="shipping_charges" name="shipping_charges">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__('general.note')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" name="additional_note">{{ old('additional_note') }}</textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <button class="btn btn-primary" type="submit">{{ __('save') }}</button>
                                    <h5 class="float-end">{{__('purchase.net_total')}}: <span id="net_total"></span> </h5>
                                    <input type="hidden" name="net_total" id="total_net">
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
<script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#selProduct").select2({
            placeholder: 'Cari Produk...',
            ajax: {
                url: domainpath + '/pos-admin/stock-transfer/getProduct?store=' + "{{Session::get('mystore')}}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: false
            }
        });

    });



    $("select[name='getProduct']").change(function(e) {
        if ($(this).val() != '0') {
            var url = domainpath + "/pos-admin/purchase/get-dom-item/" + $(this).val();
            spinner.show();
            e.preventDefault();
            setTimeout(function() {
                $.ajax({
                    url: domain + url,
                    type: 'GET',
                    data: '',
                    success: function(data) {
                        var product = data.product;
                        var dataContent = '';
                        var buttonContent = '';

                        dataContent +=
                            '<tr class="items"><td><div class="col-md-10 form-group"><input type="hidden" name="variant_id[]" value="' +
                            product.id +
                            '"><input type="hidden" name="product_id[]" value="' +
                            product.pid +
                            '"><input type="text" class="form-control" required name="variant_name[]"  value="' +
                            product.name +
                            '"  readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="qty[]" id="qty" value="1" min="1" max="' +
                            product.stock +
                            '" required><span class="error d-none" style="color: red;">* {{__("transfer.qty_have")}} ' +
                            product.stock +
                            '</span></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="unit_cost[]" value="' +
                            formatRupiah(product.p_price) +
                            '" id="unit_cost" required ></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="line_total[]" id="line_total" value="' +
                            formatRupiah(product.p_price) +
                            '" readonly></div></td>    <td><button type="button" class="btn btn-sm btn-danger delete_items"><i  class="fas fa-minus-circle"></i></button></td></tr>';
                        $("#defaulth").append(dataContent);
                        spinner.hide();
                        $(".po_items").trigger("change");
                        $(".discount_card").trigger("change");

                    },

                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

        }
    });

    $(".po_items").on("change", function() {
        var totalItems = 0;
        var totalAmount = 0;
        $(this).find('input#qty').each(function() {
            totalItems += parseInt($(this).val());
        });
        $(this).find('input#line_total').each(function() {
            totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
        });
        $("#items_total").html(totalItems);
        $("#total_items").val(totalItems);
        $("#amount_total").html(formatRupiah(totalAmount.toString()));
        $("#total_amount").val(totalAmount);
        $('.items').trigger("keyup");
    });
    $(".discount_card").on("change", function() {

        var discount = 0;
        var discAmount = 0;
        var shipping = $(this).find("input#shipping_charges").val();
        var amount = $("input#total_amount").val();
        $(this).find("input#shipping_charges").val(formatRupiah(shipping.toString()));
        var shipping = $(this).find("input#shipping_charges").val();
        if (shipping == null || shipping == '') {
            shipping = 0;
        }
        var discount = parseInt(amount) + parseInt(shipping.replace(/[^0-9]/g, '').toString());

        $(this).find("#net_total").html(formatRupiah(discount.toString()));
        $(this).find("input#total_net").val(discount);
    });


    $("body").on("click", ".delete_items", function() {
        Swal.fire({
            title: confirmation,
            text: warning,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: yes_sure
        }).then(result => {
            $(this).parents(".items").remove();
            $(".po_items").trigger("change");
            $(".discount_card").trigger("change");
        });
    });



    $("body").on("change", ".items", function(e) {

        var value = e.target.value;
        var max = e.target.max;
        var s_price = $(this).find("input#unit_cost").val();
        var qty = $(this).find("input#qty").val();
        var lineTotal = parseInt(s_price.replace(/[^0-9]/g, '').toString()) * qty;
        $(this).find("input#line_total").val(formatRupiah(lineTotal.toString()));

        if (parseInt(value) > parseInt(max)) {
            $(this).find(".error").removeClass("d-none");

            var lineTotal = parseInt(s_price.replace(/[^0-9]/g, '').toString()) * parseInt(max);
            $(this).find("input#line_total").val(formatRupiah(lineTotal.toString()));
            $(this).find("input#qty").val(max);
            $(".po_items").trigger("change");
            $(".discount_card").trigger("change");
            return false;
        } else {
            $(this).find(".error").addClass("d-none");
        }
        $(".po_items").trigger("change");
        $(".discount_card").trigger("change");
    });
</script>
@endsection
@endsection