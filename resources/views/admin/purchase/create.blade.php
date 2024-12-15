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
            <form id="" method="POST" action="{{ route('purchase.store') }}" enctype="multipart/form-data" class="col-md-12 col-12">
                @csrf

                {{-- GENERAL INFORMATION --}}
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px">{{ $page }}</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('sidebar.supplier') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="supplier_id" id="supplier_id">
                                                <option value="">{{ __('general.choose_supplier') }}</option>
                                                @foreach ($data['supplier'] as $s)
                                                <option value="{{ $s->id }}" @if ($s->id == old('supplier_id')) selected @endif>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.ref_no') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('ref_no') }}" id="product_sku" name="ref_no">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('purchase.date') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('transaction_date', date('Y-m-d H:i')) }}" id="transaction_date" name="transaction_date" readonly>
                                                <button class="btn btn-primary" type="button" id="transaction_date"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('purchase.status') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="status" id="st">
                                                <option value="">{{ __('produk.choose_status') }}</option>
                                                @foreach ($data['status'] as $s => $values)
                                                <option value="{{ $s }}" @if ($s==old('status')) selected @endif>{{ $values }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{ __('general.file') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="form-control" type="file" id="file" name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END GENERAL INFORMATION --}}

                {{-- PRODUCT LIST --}}
                <div class="card  ">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="table-responsive po_items">
                                            <div class="content-center">
                                                <div class="input-group mb-3">
                                                    <select id='selProduct' required name='getProduct' class='js-example-basic-single' style='width: 100%;'>
                                                        <option value=''>{{ __('produk.search_product') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="table-1">
                                                    <thead>
                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                            <td>{{ __('produk.name') }} </td>
                                                            <td>{{ __('purchase.quantity') }}</td>
                                                            <td>{{ __('purchase.unit_cost') }} ({{ __('purchase.before_discount') }}) </td>
                                                            <td>{{ __('purchase.discount_percentase') }}</td>
                                                            <td width="10%">{{__('purchase.tax')}}</td>
                                                            <td>{{ __('purchase.unit_cost') }} ({{ __('purchase.after_discount') }}) </td>
                                                            <td>{{__('purchase.unit_cost')}} ({{__('purchase.after_tax')}}) </td>
                                                            <td>{{__('general.subtotal')}}</td>
                                                            <td>{{ __('general.margin') }}</td>
                                                            <td>{{ __('general.sell_price') }} </td>
                                                            <td><i class="fa fa-trash"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="defaulth">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr style="border: 1px solid black;">
                                            <h5 class="float-end">{{__('purchase.items_total')}}: <span id="items_total"></span> </h5>
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
                {{-- END PRODUCT LIST --}}

                {{-- DISCOUNT --}}
                <div class="card   discount_card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.discount_type')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="type_discount" id="type_discount">
                                                <option value="">{{__('general.none')}}</option>
                                                <option value="percent">{{__('general.percentase')}}</option>
                                                <option value="fixed">{{__('general.fixed')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.discount_amount')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('discount_total') }}" id="discount_total" value="0" name="discount_total" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.purchase_tax')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="tax_po" id="tax_po">
                                                <option value="0">{{__('general.none')}}</option>
                                                @foreach ($data['taxrate'] as $t)
                                                <option value="{{ $t->taxrate }}">{{ $t->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.shipping_detail')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('shipping_details') }}" id="shipping_details" name="shipping_details">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('purchase.shipping_cost')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('shipping_charges', 0) }}" id="shipping_charges" name="shipping_charges">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>{{__('general.note')}}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" name="additional_note">{{ old('additional_note') }}</textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <h5 class="float-end">{{__('purchase.discount_total')}} : <span id="discount_amount"></span> </h5>
                                    <input type="hidden" name="discount_amount" id="amount_discount">
                                    <br><br>
                                    <h5 class="float-end" style="margin-top: -20px">{{__('purchase.net_total')}} : <span id="net_total"></span> </h5>
                                    <input type="hidden" name="net_total" id="total_net">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END DISCOUNT --}}

                {{-- PAYMENT --}}
                <div class="card  blue-card payment_card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row" id="paymentsession">
                                        <div class="col-md-6 form-group">
                                            <label>{{__('general.payment_method')}}</label>
                                            <select class="choices form-select" name="payment_method" id="payment_method">
                                                @foreach ($data['payment_method'] as $pay => $method)
                                                <option value="{{ $pay }}">{{ $method }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label>{{__('general.payment_date')}}</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('paid_date', date('Y-m-d H:i')) }}" id="paid_date" name="paid_date" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row" id="paymentprocess">
                                                <div class="col-md-6 form-group">
                                                    <label>{{__('general.payment_total')}}</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" value="{{ old('payment_amount',0) }}" id="payment_amount" value="0" name="payment_amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>{{__('general.payment_note')}}</label>
                                            <textarea class="form-control" name="payment_note">{{ old('payment_note') }}</textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <h5 class="float-end">{{__('general.payment_due')}}: <span id="payment_due"></span> </h5>
                                    <input type="hidden" name="payment_due" id="due_payment">
                                    <br>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">{{ __('save') }}</button>
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
<script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('assets/vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/vendors/select3/dist/js/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $("#selProduct").select2({
            placeholder: 'Cari Produk...',
            ajax: {
                url: domainpath + '/pos-admin/purchase/getProduct/',
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

                        var optionTax = '';
                        $.each(data.taxrate, function(index, value) {
                            optionTax += '<option value="' + value.taxrate + '">' +
                                value
                                .name + '</option>';
                        });
                        dataContent +=
                            '<tr class="items"><td><div class="col-md-10 form-group"><input type="hidden" name="variant_id[]" value="' +
                            product.id +
                            '"><input type="hidden" name="product_id[]" value="' +
                            product.pid +
                            '"><input type="text" class="form-control" required name="variant_name[]"  value="' +
                            product.name +
                            '"  readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="qty[]" id="qty" value="1" required></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="unit_cost[]" value="' +
                            formatRupiah(product.p_price) +
                            '" id="unit_cost" required ></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="discount_percent[]" value="0" id="discount_percent" required ></div></td><td><div class="col-md-10 form-group"><select id="tax_price" name="tax_price[]" class="form-control tax_price"><option value="0">None</option>' +
                            optionTax +
                            '</select></div></td><td> <div class="col-md-10 form-group"><input type="text" class="form-control" name="unit_cost_adiscount[]" id="unit_cost_adiscount" value="' +
                            formatRupiah(product.p_price) +
                            '" required readonly></div></td><td> <div class="col-md-10 form-group"><input type="text" class="form-control" name="unit_cost_atax[]" id="unit_cost_atax" value="' +
                            formatRupiah(product.p_price) +
                            '" required readonly></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="line_total[]" id="line_total" value="' +
                            formatRupiah(product.p_price) +
                            '" readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="margin[]" id="margin" value="' +
                            product.margin +
                            '" required></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="selling_price[]" id="selling_price" value="' +
                            formatRupiah(product.s_price) +
                            '" required></div></td><td><button type="button" class="btn btn-sm btn-danger delete_items"><i  class="fas fa-minus-circle"></i></button></td></tr>';
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

    $("body").on("keyup", ".items", function() {
        var taxrate = $(this).find("select#tax_price").val();
        var before_discount = $(this).find("input#unit_cost").val();
        $(this).find("input#unit_cost").val(formatRupiah(before_discount));
        var before_discount = $(this).find("input#unit_cost").val();
        var disc = $(this).find("input#discount_percent").val();
        var discount = parseInt(before_discount.replace(/[^0-9]/g, '').toString()) - (parseInt(before_discount.replace(/[^0-9]/g, '').toString()) * disc / 100);

        var getTax = (parseInt(taxrate) / 100) * discount;
        var tax = getTax + discount;

        $(this).find("input#unit_cost_adiscount").val(formatRupiah(discount.toString()));
        $(this).find("input#unit_cost_atax").val(formatRupiah(discount.toString()));
        $(".discount_card").trigger("change");
        $(".payment_card").trigger("change");

        var before_discount = $(this).find("input#unit_cost").val();
        var disc = $(this).find("input#discount_percent").val();

        var discount = before_discount.replace(/[^0-9]/g, '').toString() - (before_discount.replace(/[^0-9]/g, '').toString() * disc / 100);
        var getTax = (parseInt(taxrate) / 100) * discount;
        var tax = getTax + discount;

        $(this).find("input#unit_cost_adiscount").val(formatRupiah(discount.toString()));
        $(this).find("input#unit_cost_atax").val(formatRupiah(tax.toString()));
        $(".discount_card").trigger("change");
        $(".payment_card").trigger("change");
    });
    $("body").on("change", ".items", function() {
        var after_disc = $(this).find("input#unit_cost_adiscount").val();
        var s_price = $(this).find("input#selling_price").val();
        var after_tax = $(this).find("input#unit_cost_atax").val();
        var qty = $(this).find("input#qty").val();
        var countPercentase = (s_price.replace(/[^0-9]/g, '').toString() / after_tax.replace(/[^0-9]/g, '').toString()) * 100 - 100;
        var lineTotal = after_tax.replace(/[^0-9]/g, '').toString() * qty;
        $(this).find("input#margin").val(countPercentase.toFixed(0));
        $(this).find("input#line_total").val(formatRupiah(lineTotal.toString()));
        $(".po_items").trigger("change");
        $(".discount_card").trigger("change");
        $(".payment_card").trigger("change");
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
        var amount = $("input#total_amount").val();
        var type = $(this).find("select#type_discount").val();
        var disc = $(this).find("input#discount_total").val();
        var shipping = $(this).find("input#shipping_charges").val();
        $(this).find("input#shipping_charges").val(formatRupiah(shipping));
        var shipping = $(this).find("input#shipping_charges").val();
        var tax = $(this).find("select#tax_po").val();
        if (shipping == null || shipping == '') {
            shipping = 0;
        }
        if (disc == null || disc == '') {
            disc = 0;
        }
        if (amount != 0) {
            if (type == 'percent') {
                var discAmount = parseInt(amount) * parseInt(disc) / 100;
                var fix = parseInt(amount) - parseInt(discAmount);
                var taxrate = (tax / 100) * fix;
                var discount = fix + parseInt(taxrate) + parseInt(shipping.replace(/[^0-9]/g, '').toString());
                console.log(taxrate, discount);
            } else if (type == 'fixed') {
                $(this).find("input#discount_total").val(disc);
                var disc = $(this).find("input#discount_total").val();
                var discAmount = disc;
                var fix = parseInt(amount) - parseInt(disc.replace(/[^0-9]/g, '').toString());
                var taxrate = (tax / 100) * fix;
                var discount = fix + parseInt(taxrate) + parseInt(shipping.replace(/[^0-9]/g, '').toString());
            } else if (type == '') {
                var fix = amount;
                var taxrate = (tax / 100) * parseInt(fix);
                var discount = parseInt(fix) + parseInt(taxrate) + parseInt(shipping.replace(/[^0-9]/g, '').toString());
                console.log(discount, taxrate, fix);
            }
        }

        $(this).find("#net_total").html(formatRupiah(discount.toString()));
        $(this).find("input#total_net").val(discount);
        $(this).find("input#amount_discount").val(discAmount);
        $(this).find("#discount_amount").html(formatRupiah(discAmount.toString()));
        $(".payment_card").trigger("change");
    });
    $(".payment_card").on("change", function() {
        var discount = 0;
        var discAmount = 0;
        var amount = $("input#total_net").val();
        var pay = $(this).find("input#payment_amount").val();
        $(this).find("input#payment_amount").val(formatRupiah(pay.toString()));
        var pay = $(this).find("input#payment_amount").val();
        var due = amount - pay.replace(/[^0-9]/g, '').toString();
        $(this).find("#payment_due").html(formatRupiah(due.toString()));
        $(this).find("#due_payment").val(due);
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
            $(".payment_card").trigger("change");
        });
    });



    $("select[name='type_discount']").change(function(e) {
        var select = $(this).val();
        if (select == "") {
            $("#discount_total").attr("readonly", "");
            $("#discount_total").val(0);
        } else {
            $("#discount_total").removeAttr("readonly");
        }
    });
</script>
@endsection
@endsection