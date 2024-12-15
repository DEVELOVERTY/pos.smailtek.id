@extends('layouts.admin')
@section('content')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/css/dropify.min.css') }}">
    <link href="{{ asset('assets/vendors/summernote/summernote.min.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/vendors/select3/dist/css/select2.min.css') }}" />
@endsection

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $page }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <x-admin.validation-component></x-admin.validation-component>

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <form id="" method="POST" action="{{ route('purchase.store') }}" enctype="multipart/form-data"
                class="col-md-12 col-12">
                @csrf
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ __('supplier') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="{{ $data['po']->id }}">
                                            <select class="choices form-select" name="supplier_id" id="supplier_id">
                                                @foreach ($data['supplier'] as $s)
                                                    <option value="{{ $s->id }}" @if ($s->id == old('supplier_id',$data['po']->supplier_id)) selected @endif>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>{{ __('reference_format') }}*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="{{ old('ref_no',$data['po']->ref_no) }}"
                                                    id="product_sku" name="ref_no" readonly>
                                                <button class="btn btn-outline-secondary" type="button" ><i
                                                        class="fas fa-random"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>{{ __('purchase') }} {{ __('date') }} *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('transaction_date', $data['po']->transaction_date) }}"
                                                    id="transaction_date" name="transaction_date" readonly>
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="transaction_date"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <label>{{ __('status') }}</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="status" id="status">
                                                <option value="">{{ __('choose') }} {{ __('status') }}</option>
                                                @foreach ($data['status'] as $s => $values)
                                                    <option value="{{ $s }}" @if ($s == old('status',$data['po']->status)) selected @endif>{{ $values }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label>{{ __('file') }}</label>
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

                <div class="card" style="border-top: 2px solid blue">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="table-responsive po_items">
                                            <div class="content-center">
                                                <div class="input-group mb-3">
                                                    <select id='selProduct' required name='getProduct'
                                                        class='js-example-basic-single' style='width: 100%;'>
                                                        <option value=''>{{ __('select') }}
                                                            {{ __('product') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table" id="table-1">
                                                    <thead>
                                                        <tr style="background-color: #3c8dbc; border: 1px solid white"
                                                            class="text-white">
                                                            <td>{{ __('product') }} {{ __('name') }}
                                                            </td>
                                                            <td>{{ __('quantity') }}</td>
                                                            <td>{{ __('unit_cost') }}
                                                                ({{ __('before_discount') }}) </td>
                                                            <td>{{ __('discount_percentase') }}</td>
                                                            <td width="10%">Pajak</td>
                                                            <td>{{ __('unit_cost') }} ({{ __('after_discount') }})
                                                            </td>
                                                            <td>Biaya Satuan (Setelah Pajak) </td>

                                                            <td>Subtotal</td>
                                                            <td>{{ __('margin') }}</td>
                                                            <td>{{ __('selling_price') }} </td>
                                                            <td><i class="fa fa-trash"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="defaulth">
                                                        @php 
                                                        $qtyall  = 0;
                                                        $net    = 0;
                                                        @endphp 
                                                        @foreach($data['po']->purchase as $p)
                                                        @php 
                                                        $subtotal = $p->purchase_price_inc_tax * $p->quantity;
                                                        $sprice = $p->variation->selling_price;
                                                        $atax   = $p->purchase_price_inc_tax;
                                                        $margin = ($sprice / $atax) * 100 - 100; 

                                                        $qtyall += $p->quantity;
                                                        $net += $subtotal;
                                                        @endphp 
                                                        <tr class="items">
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="hidden" name="variant_id[]" value="{{$p->variation_id}}">
                                                                    <input type="hidden" name="product_id[]" value="{{$p->product_id}}">
                                                                    <input type="text" class="form-control" required name="variant_name[]"  value="{{$p->product->name . " - ".$p->variation->name}}"  readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="qty[]" id="qty" value="{{$p->quantity}}" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="unit_cost[]" value="{{$p->without_discount}}" id="unit_cost" required >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="discount_percent[]" value="{{$p->discount_percent}}" id="discount_percent" required >
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <select id="tax_price" name="tax_price[]" class="form-control tax_price">
                                                                        @foreach ($data['taxrate'] as $tax )
                                                                            <option value="{{$tax->taxrate}}" @if($tax->taxrate == $p->item_tax) selected @endif>{{$tax->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td> 
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="unit_cost_adiscount[]" id="unit_cost_adiscount" value="{{$p->purchase_price}}" required readonly>
                                                                </div>
                                                            </td>
                                                            <td> 
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="unit_cost_atax[]" id="unit_cost_atax" value="{{$p->purchase_price_inc_tax}}" required readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="line_total[]" id="line_total" value="{{$subtotal}}" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="margin[]" id="margin" value="{{ ceil($margin) }}" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-10 form-group">
                                                                    <input type="number" class="form-control" name="selling_price[]" id="selling_price" value="{{$p->variation->selling_price}}" required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                -
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr style="border: 1px solid black;">
                                            <h5 class="float-end">Total Items: <span id="items_total">{{ $qtyall }}</span> </h5>
                                            <input type="hidden" name="items_total" value="{{ $qtyall }}" id="total_items">
                                            <br><br>
                                            <h5 class="float-end" style="margin-top: -20px">Net Total Amount: <span
                                                    id="amount_total">{{ $net }}</span> </h5>
                                            <input type="hidden" name="amount_total" value="{{ $net }}" id="total_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card discount_card" style="border-top: 2px solid blue">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Tipe Discount</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="type_discount" id="type_discount">
                                                <option value="">None</option>
                                                @if($data['po']->discount_type != null)
                                                    @if($data['po']->discount_type == 'percent')
                                                        <option value="percent">Percentage</option>
                                                        <option value="fixed">Fixed</option>
                                                    @else 
                                                        <option value="fixed">Fixed</option>
                                                        <option value="percent">Percentage</option> 
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jumlah Discount</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('discount_total') }}" id="discount_total" value="{{ $data['po']->discount_amount }}"
                                                    name="discount_total" readonly="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Pajak Purchase</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="tax_po" id="tax_po">
                                                <option value="0">None</option>
                                                @foreach($data['taxrate'] as $t)
                                                    <option value="{{ $t->taxrate }}" @if(number_format($data['po']->tax_amount) == $t->taxrate) selected @endif>{{ $t->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Details Pengiriman</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('shipping_details',$data['po']->shipping_details) }}" id="shipping_details"
                                                    name="shipping_details">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Biaya Kirim</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('shipping_charges', number_format($data['po']->shipping_charges)) }}" id="shipping_charges"
                                                    name="shipping_charges">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Catatan</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control"
                                                name="additional_note">{{ old('additional_note',$data['po']->additional_note) }}</textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <h5 class="float-end">Discount Amount: <span id="discount_amount">{{ ceil($data['po']->discount_amount) }}</span> </h5>
                                    <input type="hidden" name="discount_amount" id="amount_discount">
                                    <br><br>
                                    <h5 class="float-end" style="margin-top: -20px">Net Total: <span
                                            id="net_total"></span> </h5>
                                    <input type="hidden" name="net_total" id="total_net">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card payment_card" style="border-top: 2px solid blue">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Payment Method</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="payment_method"
                                                id="payment_method">
                                                @foreach ($data['payment_method'] as $pay => $method)
                                                    <option value="{{ $pay }}">{{ $method }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Jumlah Pembayaran</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('payment_amount') }}" id="payment_amount" value="0"
                                                    name="payment_amount">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Tanggal Bayar</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control"
                                                    value="{{ old('paid_date', date('Y-m-d H:i')) }}" id="paid_date"
                                                    name="paid_date" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Payment Note</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control"
                                                name="payment_note">{{ old('payment_note') }}</textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <h5 class="float-end">Payment Due: <span id="payment_due"></span> </h5>
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
    </section>

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
                                optionTax += '<option value="' + value.taxrate + '">' + value
                                    .name + '</option>';
                            });
                            dataContent +=
                                '<tr class="items"><td><div class="col-md-10 form-group"><input type="hidden" name="variant_id[]" value="' +
                                product.id +
                                '"><input type="hidden" name="product_id[]" value="' +
                                product.pid +
                                '"><input type="text" class="form-control" required name="variant_name[]"  value="' +
                                product.name +
                                '"  readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="qty[]" id="qty" value="1" required></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="unit_cost[]" value="' +
                                product.p_price +
                                '" id="unit_cost" required ></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="discount_percent[]" value="0" id="discount_percent" required ></div></td><td><div class="col-md-10 form-group"><select id="tax_price" name="tax_price[]" class="form-control tax_price"><option value="0">None</option>' +
                                optionTax +
                                '</select></div></td><td> <div class="col-md-10 form-group"><input type="number" class="form-control" name="unit_cost_adiscount[]" id="unit_cost_adiscount" value="' +
                                product.p_price +
                                '" required readonly></div></td><td> <div class="col-md-10 form-group"><input type="number" class="form-control" name="unit_cost_atax[]" id="unit_cost_atax" value="' +
                                product.p_price +
                                '" required readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="line_total[]" id="line_total" value="' +
                                product.p_price +
                                '" readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="margin[]" id="margin" value="' +
                                product.margin +
                                '" required></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="selling_price[]" id="selling_price" value="' +
                                product.s_price +
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




        $(".po_items").on("change", function() {
            var totalItems = 0;
            var totalAmount = 0;
            $(this).find('input#qty').each(function() {
                totalItems += parseInt($(this).val());
            });
            $(this).find('input#line_total').each(function() {
                totalAmount += parseInt($(this).val());
            });
            $("#items_total").html(totalItems);
            $("#total_items").val(totalItems);
            $("#amount_total").html(totalAmount);
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
            var tax = $(this).find("select#tax_po").val(); 
            if(shipping == null || shipping == '') {
                shipping = 0;
            }
            if(disc == null || disc == '')
            {
                disc = 0;
            }
            if (amount != 0) {
                if (type == 'percent') {
                    var discAmount = parseInt(amount) * parseInt(disc) / 100;
                    var fix = parseInt(amount) - parseInt(discAmount);
                    var taxrate = (tax / 100) * fix;
                    var discount = fix + parseInt(taxrate) + parseInt(shipping); 
                } else if (type == 'fixed') {
                    var discAmount = disc;
                    var fix = parseInt(amount) - parseInt(disc);
                    var taxrate = (tax / 100) * fix;
                    var discount = fix + parseInt(taxrate) + parseInt(shipping);
                } else if (type == '') {
                    var discount = amount;
                }
            }

            $(this).find("#net_total").html(discount);
            $(this).find("input#total_net").val(discount);
            $(this).find("input#amount_discount").val(discAmount);
            $(this).find("#discount_amount").html(discAmount);
            $(".payment_card").trigger("change");
        });
        $(".payment_card").on("change", function() {
            var discount = 0;
            var discAmount = 0;
            var amount = $("input#total_net").val();
            var pay = $(this).find("input#payment_amount").val();
            var due = amount - pay;
            $(this).find("#payment_due").html(due);
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


        $("body").on("keyup", ".items", function() {
            var taxrate = $(this).find("select#tax_price").val(); 
            var before_discount = $(this).find("input#unit_cost").val();
                var disc = $(this).find("input#discount_percent").val();  
                var discount = before_discount - (before_discount * disc / 100);
                var getTax = (parseInt(taxrate) / 100) * discount;
                var tax = getTax + discount;
                $(this).find("input#unit_cost_adiscount").val(before_discount);
                $(this).find("input#unit_cost_adiscount").val(discount.toFixed(0));
                $(this).find("input#unit_cost_atax").val(tax.toFixed(0));
                $(".discount_card").trigger("change");
                $(".payment_card").trigger("change");
                var before_discount = $(this).find("input#unit_cost").val();
                var disc = $(this).find("input#discount_percent").val();  
                var discount = before_discount - (before_discount * disc / 100);
                var getTax = (parseInt(taxrate) / 100) * discount;
                var tax = getTax + discount;
                $(this).find("input#unit_cost_adiscount").val(before_discount);
                $(this).find("input#unit_cost_adiscount").val(discount.toFixed(0));
                $(this).find("input#unit_cost_atax").val(tax.toFixed(0));
                $(".discount_card").trigger("change");
                $(".payment_card").trigger("change");
        });
        $("body").on("change", ".items", function() {
            var after_disc = $(this).find("input#unit_cost_adiscount").val();
            var s_price = $(this).find("input#selling_price").val();
            var after_tax = $(this).find("input#unit_cost_atax").val();
            var qty = $(this).find("input#qty").val();
            var countPercentase = (s_price / after_tax) * 100 - 100;
            var lineTotal = after_tax * qty;
            $(this).find("input#margin").val(countPercentase.toFixed(0));
            $(this).find("input#line_total").val(lineTotal);
            $(".po_items").trigger("change");
            $(".discount_card").trigger("change");
            $(".payment_card").trigger("change");
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
