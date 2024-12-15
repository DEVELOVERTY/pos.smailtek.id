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
                    @can("Daftar Penjualan")
                    <a class="btn btn-md btn-primary float-end" href="{{ route('sell.report') }}"><i class="fa fa-list"></i> {{__('sidebar.sell_report')}}</a>
                    @endcan
                </div>
            </div>
        </div>
        <x-admin.validation-component></x-admin.validation-component>

        <div class="row match-height">
            <form id="" method="POST" action="{{ route('returnsell.store') }}" enctype="multipart/form-data" class="col-md-12 col-12">
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
                                                <input type="hidden" name="transaction_id" id="transactionid" value="{{ $data->id }}">
                                                <input type="text" class="form-control" value="{{ old('ref_no') }}" id="product_sku" name="ref_no">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <select id='selProduct' required name='getProduct' class='js-example-basic-single' style='width: 100%;'>
                                                <option value=''>{{ __('produk.search_product') }} </option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="table-responsive po_items">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table-1">
                                                        <thead>
                                                            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                                <td>{{__('produk.name')}}</td>
                                                                <td>{{__('sell.condition')}}</td>
                                                                <td>{{__('purchase.return_have')}}</td>
                                                                <td>{{__('purchase.unit_cost')}} </td>
                                                                <td>{{__('purchase.return_qty')}}</td>
                                                                <td width="10%">{{__('purchase.return_subtotal')}}</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="defaulth">


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
<script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
<script>
    var idtransaction = $("#transactionid").val();
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $("#selProduct").select2({
            placeholder: 'Cari Produk...',
            ajax: {
                url: domainpath + '/pos-admin/return-sell/sell-return/' + idtransaction,
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
            var url = domainpath + "/pos-admin/return-sell/return-dom/" + $(this).val();
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

                        var optionTax = '';
                        $.each(data.taxrate, function(index, value) {
                            optionTax += '<option value="' + value.taxrate + '">' +
                                value
                                .name + '</option>';
                        });
                        var sellID = $("#sellId-" + product.sell_id).val();
                        if (sellID == undefined) {
                            dataContent +=
                                `<tr>
                                        <td>` + product.name + `</td>
                                        <td>
                                            <select class="form-control" name="condition[]">
                                                <option value="good">{{__('sell.good')}}</option>
                                                <option value="broken">{{__('sell.broken')}}</option>
                                            </select>
                                        </td>
                                        <td> ` + product.stock + ` </td>
                                        <td> ` + product.s_price + `</td>
                                        <td width="15%">
                                            <input type="hidden" name="sell_id[]" id="sellId-` + product.sell_id + `" value="` + product.sell_id + `">
                                            <input type="hidden" name="product_id[]" value="` + product.product_id + `">
                                            <input type="hidden" name="variation_id[]" value="` + product.var_id + `">
                                            <input type="hidden" id="sellprice` + product.sell_id + `" value="` + product.price + `">
                                            <input type="number" class="form-control qty_return"  name="qty_return[]" id="` + product.sell_id + `"  min="0" max="` + product.stock + `" value="0">
                                            <span class="error-` + product.sell_id + ` d-none" style="color: red;">* {{__('purchase.max_qty')}}</span>
                                        </td>
                                        <td width="10%">
                                            <input type="text" name="subtotal_return[]" class="form-control subtotalreturn" id="subtotal` + product.sell_id + `" value="0" readonly>
                                        </td>
                                    </tr>`;
                            $("#defaulth").append(dataContent);
                        }

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

    $("#defaulth").on("change", ".qty_return", function(e) {
        var value = e.target.value;
        var max = e.target.max;
        var price = $("#sellprice" + e.target.id).val();
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