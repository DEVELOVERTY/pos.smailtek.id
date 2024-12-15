("use strict");
$(function () {
    ourProduct();
});
moment.lang("id");

$(".select2").select2({
    width: 'resolve' // need to override the changed default
});

/**
 *  Offline & Online Detection
 */
window.addEventListener("online", function () {
    toastr.success(internet_connected, {
        positionClass: "toast-bottom-left",
        timeOut: 5e3,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1,
    });
    playSound(domainpath + "/public/sound/connection");
});

window.addEventListener("offline", function () {
    toastr.error(offline_internet, {
        positionClass: "toast-top-right",
        timeOut: 5e3,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        preventDuplicates: !0,
        onclick: null,
        showDuration: "100",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1,
    });
    playSound(domainpath + "/public/sound/connection");
});

const rupiah = (total) => {
    return new Intl.NumberFormat({
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(total);
};

var paytotal = document.getElementById("on_pay");
paytotal.addEventListener("keyup", function (e) {
    paytotal.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^.\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? rupiah : "";
}

/**
 *  Seacrh Product
 */

$("#searchProduct").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#productData .productList").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

$("#searchProduct").keypress(function (e) {
    if (e.which == 13) {
        return false;
    }
});

/**
 *  Function Get Product
 */

function ourProduct() {
    $.ajax({
        url: domain + domainpath + "/pos/product/index",
        type: "GET",
        data: "",
        success: function (data) {
            var addCart = "";
            var dataProduct = "";
            $.each(data.products, function (index, value) {
                addCart =
                    `<button id="` +
                    value.id +
                    `" type="button" onclick="addCart(this.id)" class="btn btn-primary btn-block btn-sm"><i class="feather-shopping-cart"></i> <i class="feather-plus"></i></button>`;
                dataProduct +=
                    `<div class="col-4 pr-1 mb-4 productList" id="productID-` +
                    value.index +
                    `">
                                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                    <div class="myproductbarcode d-none">` +
                    value.barcode +
                    `</div>
                                        <div class="list-card-image">
                                            <div class="star position-absolute"><span class="badge badge-success" id="productPrice">` +
                    value.price +
                    `</span></div>
                                                <a href="javascript:void(0)">
                                                    <img id="productImage" style="height:100px;" src="` +
                    value.image +
                    `" class="img-fluid item-img w-100" alt="` +
                    value.name +
                    `">
                                                </a>
                                            </div>
                                            <div class="p-3 position-relative">
                                                <div class="list-card-body">
                                                    <p class="mb-1" >
                                                        <a href="javascript:void(0)" style="font-size:12px" class="text-black productName" id="productName` +
                    value.id +
                    `" >` +
                    value.name +
                    `</a>
                                                    </p>
                                                </div>
                                            </div>
                                            ` +
                    addCart +
                    `
                                        </div>
                                    </div>`;
            });
            document.getElementById("productData").innerHTML = dataProduct;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
}

// End Product

/**
 *  Function Get Product By Category
 */

function bycategory(idproduct) {
    var url = domainpath + "/pos/product/category/" + idproduct;
    $.ajax({
        url: domain + url,
        type: "GET",
        data: "",
        success: function (data) {
            var addCart = "";
            var dataProduct = "";
            $.each(data.products, function (index, value) {
                addCart =
                    `<button id="` +
                    value.id +
                    `" type="button" onclick="addCart(this.id)" class="btn btn-primary btn-block btn-sm"><i class="feather-shopping-cart"></i> <i class="feather-plus"></i></button>`;
                dataProduct +=
                    `<div class="col-4 pr-1 mb-4 productList" id="productID-` +
                    value.index +
                    `">
                                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                    <div class="myproductbarcode d-none">` +
                    value.barcode +
                    `</div>
                                        <div class="list-card-image">
                                            <div class="star position-absolute"><span class="badge badge-success" id="productPrice">` +
                    value.price +
                    `</span></div>
                                                <a href="javascript:void(0)">
                                                    <img id="productImage" style="height:100px;" src="` +
                    value.image +
                    `" class="img-fluid item-img w-100" alt="` +
                    value.name +
                    `">
                                                </a>
                                            </div>
                                            <div class="p-3 position-relative">
                                                <div class="list-card-body">
                                                    <p class="mb-1" >
                                                        <a href="javascript:void(0)" style="font-size:12px" class="text-black productName" id="productName` +
                    value.id +
                    `" >` +
                    value.name +
                    `</a>
                                                    </p>
                                                </div>
                                            </div>
                                            ` +
                    addCart +
                    `
                                        </div>
                                    </div>`;
            });
            document.getElementById("productData").innerHTML = dataProduct;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
}

// End by Category

/**
 *  Add Cart Function
 */

function addCart(id) {
    playSound(domainpath + "/public/sound/beep-29");
    $.ajax({
        url: domain + domainpath + "/pos/getProduct/" + id,
        type: "GET",
        data: "",
        success: function (data) {
            var addCart = "";
            var listProduct = "";
            $.each(data.product, function (index, value) {
                if (
                    $("#cartProduct")
                        .find("#cart" + value.id)
                        .html() == null
                ) {
                    listProduct +=
                        `<tr class="table-success cart-` +
                        value.id +
                        `" onchange="changePrice(this.id)" id="cart` +
                        value.id +
                        `">
                    <td>
                        <input type="hidden" id="productID" name="variation_id[]" value="` +
                        value.id +
                        `">
                        <input type="hidden" id="totalPrice" name="totalPrice[]" value="` +
                        value.tprice +
                        `">
                        <input type="hidden" id="product_name"  value="` +
                        value.fullname +
                        `">
                        
                        <input type="hidden" id="product_id" name="product_id[]"  value="` +
                        value.product_id +
                        `">
                        <input type="number" id="qty" name="qty[]" value="1" min="1" max="` +
                        value.stock +
                        `" class="form-control"> 
                    </td>
                    <td>` +
                        value.name +
                        `</td>
                    <td id="listPrice"><input type="text" id="product_pricing" class="form-control" name="unit_cost[]"  value="` +
                        rupiah(value.tprice) +
                        `"></td>
                    <td id="">
                        <input type="text" id="listTotal" name="subtotal[]" value="` +
                        rupiah(value.tprice) +
                        `" class="form-control" readonly> 
                    </td>
                    <td><a id="` +
                        value.id +
                        `" class="deletebil"  style="color:red; text-decoration:none;"> <i class="feather-trash"></i></a></td>
                </tr>`;
                } else {
                    var total = 0;
                    var newQty = 0;
                    var getQty = $("#cart" + value.id)
                        .find("#qty")
                        .val();
                    var newQty = parseInt(getQty) + 1;

                    var stringprice = $("#cart" + value.id)
                        .find("#product_pricing")
                        .val();
                    var pricingproduct = stringprice.replace(/\D/g, "");
                    var total = pricingproduct * newQty;

                    console.log(total);
                    $("#cart" + value.id)
                        .find("#qty")
                        .val(newQty);
                    $("#cart" + value.id)
                        .find("input#totalPrice")
                        .val(total);
                    $("#cart" + value.id)
                        .find("#listTotal")
                        .val(rupiah(total));

                    var max = $("#cart" + value.id)
                        .find("#qty")
                        .attr("max");
                    if (parseInt(newQty) > parseInt(max)) {
                        Swal.fire(
                            {
                                title: "Stock Tidak Cukup", // this will output "Error 422: Unprocessable Entity"
                                html:
                                    `<ul class="list-group"><li class="list-group-item alert alert-danger">` +
                                    product_sisa +
                                    ` (` +
                                    value.stock +
                                    `) </li></ul>`,
                                width: "auto",
                                confirmButtonText: "Ok",
                                cancelButtonText: "Tutup",
                                showCancelButton: false,
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $("#openModal").on("click"); //this is when the form is in a modal
                                }
                            }
                        );
                        $("#cart" + value.id)
                            .find("#qty")
                            .val(max);
                        var stringprice = $("#cart" + value.id)
                            .find("#product_pricing")
                            .val();
                        var pricingproduct = stringprice.replace(/\D/g, "");
                        var total = pricingproduct * max;
                        $("#cart" + value.id)
                            .find("input#totalPrice")
                            .val(total);
                        $("#cart" + value.id)
                            .find("#listTotal")
                            .val(total);

                        return false;
                    }
                }
            });
            if ($(".cart0").find("#productID").html() == null) {
                document.getElementById("cartProduct").innerHTML = listProduct;
            } else {
                $(".cart0").after(listProduct);
            }
            totalPrice();
        },

        cache: false,
        contentType: false,
        processData: false,
    });
}

$("body").on("click", ".deletebil", function (e) {
    $(".cart-" + e.currentTarget.id).remove();
    playSound("/sound/remove");
    $(".pos-billing").trigger("change");
});

$(".pos-billing").on("change", function () {
    var totalAmount = 0;
    $(this)
        .find("input#totalPrice")
        .each(function () {
            totalAmount += parseInt($(this).val());
        });
    $("#jumlahtotal").val(rupiah(totalAmount));
    $("#fixTotal").html(rupiah(totalAmount));
});

function changePrice(id) {
    var master = $("#" + id);
    var qty = master.find("#qty").val();
    var stringprice = master.find("#product_pricing").val();
    var pricingproduct = stringprice.replace(/\D/g, "");
    var total = pricingproduct * qty;
    master.find("#listTotal").val(rupiah(total));
    master.find("#totalPrice").val(total);

    var max = master.find("#qty").attr("max");
    if (parseInt(qty) > parseInt(max)) {
        Swal.fire(
            {
                title: "Stock Tidak Cukup", // this will output "Error 422: Unprocessable Entity"
                html:
                    `<ul class="list-group"><li class="list-group-item alert alert-danger">` +
                    product_sisa +
                    ` (` +
                    max +
                    `) </li></ul>`,
                width: "auto",
                confirmButtonText: "Ok",
                cancelButtonText: "Tutup",
                showCancelButton: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#openModal").on("click"); //this is when the form is in a modal
                }
            }
        );
        master.find("#qty").val(max);

        var stringprice = master.find("#product_pricing").val();
        var pricingproduct = stringprice.replace(/\D/g, "");
        var total = pricingproduct * max;

        master.find("input#totalPrice").val(total);
        master.find("#listTotal").val(rupiah(total));

        return false;
    }
    totalPrice();
}

function otherPriceTotal() {
    totalPrice();
}

function totalPrice() {
    var discount = $("input#discount").val();
    var shipping = $("input#shipping").val();
    var tax = $("input#taxPrice").val();
    var other = $("input#other_price").val();
    var sum = 0;

    if (discount == "") {
        $("input#discount").val(0);
        discount = 0;
    }
    if (shipping == "") {
        $("input#shipping").val(0);
        shipping = 0;
    }
    if (tax == "") {
        $("input#taxPrice").val(0);
        tax = 0;
    }
    if (other == "") {
        $("input#other_price").val(0);
        other = 0;
    }
    $("input#totalPrice").each(function () {
        sum += Number(parseInt($(this).val()));
    });

    withDisc = (sum * discount) / 100;
    withTax = (sum * tax) / 100;
    fixTotal =
        sum + (parseInt(shipping) + parseInt(other)) + withTax - withDisc;
    $("#fixTotal").html(rupiah(fixTotal));
    $("#jumlahtotal").val(rupiah(fixTotal));
}

/**
 *  Modal For Pay
 */

$("body").on("click", "#pay_shop", function () {
    paymodal = $(this).closest("body");
    $("#on_due").val(paymodal.find("#fixTotal").html());
    $("#billingmodal").modal("toggle");
    document.getElementById("pay_modal_click").click();
});

$(".payment_modal").on("change", "#on_pay", function () {
    var pay = $("#on_pay").val();
    var due = $("#fixTotal").html();
    var total =
        parseInt(due.replace(/[^0-9]/g, "").toString()) -
        parseInt(pay.replace(/[^0-9]/g, "").toString());
    if (
        parseInt(pay.replace(/[^0-9]/g, "").toString()) >=
        parseInt(due.replace(/[^0-9]/g, "").toString())
    ) {
        $("#duepay").addClass("d-none");
        change = Math.abs(total);
        console.log(rupiah(change));
        $("#on_change").val(rupiah(change).toString());
        $("#changepay").removeClass("d-none");
    } else {
        $("#duepay").removeClass("d-none");
        $("#changepay").addClass("d-none");
        $("#on_due").val(rupiah(total.toString()));
    }
});

/**
 *  Customer
 */

// Create category
$("#saveCustomer").on("click", function (e) {
    spinner.show();
    e.preventDefault();

    var name = $("#name").val();
    var phone = $("#phone").val();
    var mail = $("#email").val();
    var code = $("#code").val();
    var city = $("#city").val();
    var state = $("#state").val();
    var address = $("#address").val();
    var detail = $("#detail").val();
    var url = domain + domainpath + "/pos-admin/customer/customer-store/create";
    $.post(url, {
        _token: token,
        name: name,
        phone: phone,
        email: mail,
        code: code,
        city: city,
        state: state,
        address: address,
        detail: detail,
    }).done(function () {
        $("#name").val("");
        $("#phone").val("");
        $("#email").val("");
        $("#code").val("");
        $("#city").val("");
        $("#state").val("");
        $("#address").val("");
        $("#detail").val("");
        $("#addCustomer").modal("toggle");
        var url = domain + domainpath + "/pos/get-customer";
        $("select[name='customer_id']").load(url);
        spinner.hide();
    });
});

$("#bank").on("click", function (e) {
    $("#bank").addClass("active");
    $("#cash").removeClass("active");
    $("#card").removeClass("active");

    var url = domainpath + "/pos-admin/system/get-bank/";
    $.ajax({
        url: domain + url,
        type: "GET",
        data: "",
        success: function (data) {
            var option = "";
            $.each(data.bank, function (index, value) {
                option +=
                    '<option value="' +
                    value.bank_code +
                    '">' +
                    value.bank_name +
                    "</option>";
            });
            var form =
                `<div class="col-md-6 form-group mt-3">
                        <label>No Rek</label>
                        <div class="input-group mb-3">
                        <input type="text" style="border: 1px solid black;" class="form-control" value="" id="no_rek"  name="no_rek">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Atas Nama</label>
                    <div class="input-group mb-3">
                        <input type="text" style="border: 1px solid black;" class="form-control" value="" id="an"  name="an">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Nama Bank</label>
                    <div class="input-group mb-3">
                        <select style="border: 1px solid black;" class="form-control" name="bank_id">` + option + `</select>
                    </div> 
                </div> `;
            $("#paymentprocess").html(form);
        },

        cache: false,
        contentType: false,
        processData: false,
    });
});

$("#card").on("click", function (e) {
    $("#bank").removeClass("active");
    $("#cash").removeClass("active");
    $("#card").addClass("active");

    var form = `
                <div class="col-md-6 form-group mt-3">
                    <label>Card Number</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_number"  name="card_number">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Card Holder Name</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_holder_name"  name="card_holder_name">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Card Transaction No.</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_transaction_number"  name="card_transaction_number">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Card Type</label>
                    <div class="input-group mb-3">
                        <select style="border: 1px solid black;" class="form-control" name="card_type">
                            <option value="visa">Visa</option>
                            <option value="mastercard">Master Card</option>
                            <option value="visa">debit card</option>
                        </select>
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Month</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_month"  name="card_month">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Year</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_year"  name="card_year">
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                    <label>Card Security</label>
                    <div class="input-group mb-3">
                        <input style="border: 1px solid black;" type="text" class="form-control" value="" id="card_security"  name="card_security">
                    </div> 
                </div>`;
    $("#paymentprocess").html(form);
});

$("#cash").on("click", function (e) {
    $("#bank").removeClass("active");
    $("#cash").addClass("active");
    $("#card").removeClass("active");
    $("#paymentprocess").html("");
});

$("#hold_modal").on("click", function () {
    console.log("hallo");
    $.ajax({
        url: domain + domainpath + "/pos/get-hold",
        type: "GET",
        data: "",
        success: function (data) {
            var holdData = "";
            $.each(data.transaction, function (index, value) {
                holdData +=
                    `<div class="col-6 mt-3">
                <a href="javascript:void(0)" id="` +
                    value.id +
                    `" onclick="getbill(this.id)" class="card" style="border: 2px solid blue">
                    <div class="card-body px-3 py-4-5">
                        <div class="row"> 
                            <div class="col-md-12">
                                <h6 class="text-muted font-semibold">` +
                    value.customer +
                    `</h6>
                                <h6 class="font-extrabold mb-0">(` +
                    value.invoice +
                    `) / Banyaknya Product (` +
                    value.products +
                    `)</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div> `;
            });
            document.getElementById("holdlist").innerHTML = holdData;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
});

function getbill(id) {
    var url = domainpath + "/pos/product/get-bill/" + id;
    $.ajax({
        url: domain + url,
        type: "GET",
        data: "",
        success: function (data) {
            var billing = "";
            var option =
                '<tr class="table-success cart0 d-none"><input type="hidden" id="productID"> <input type="hidden" name="transaction_id" value="' +
                data.other.id +
                '" </tr>';
            $.each(data.bill, function (index, value) {
                billing +=
                    `<tr class="table-success cart-` +
                    value.id +
                    `" onchange="changePrice(this.id)" id="cart` +
                    value.id +
                    `">
                <td>
                    <input type="hidden" id="productID" name="variation_id[]" value="` +
                    value.id +
                    `">
                    <input type="hidden" id="totalPrice" name="totalPrice[]" value="` +
                    value.tprice +
                    `">
                    <input type="hidden" id="bill" name="bill[]" value="` +
                    value.bill_id +
                    `">
                    <input type="hidden" id="product_name"  value="` +
                    value.fullname +
                    `">
                    
                    <input type="hidden" id="product_id" name="product_id[]"  value="` +
                    value.product_id +
                    `">
                    <input type="number" id="qty" name="qty[]" value="` +
                    value.qty_product +
                    `" min="1" max="` +
                    value.stock +
                    `" class="form-control"> 
                </td>
                <td>` +
                    value.name +
                    `</td>
                <td id="listPrice"><input type="text" class="form-control" id="product_pricing" name="unit_cost[]"  value="` +
                    rupiah(value.unitprice) +
                    `"></td>
                <td id="">
                    <input type="text" id="listTotal" name="subtotal[]" value="` +
                    rupiah(value.tprice) +
                    `" class="form-control" readonly> 
                </td>
                <td><a id="` +
                    value.bill_id +
                    `" onclick="deletebill(this.id,` +
                    value.id +
                    `)"  style="color:red; text-decoration:none;"> <i class="feather-trash"></i></a></td>
            </tr>`;
            });
            $("#cartProduct").html(billing);
            $("#cartProduct").append(option);
            $("#fixTotal").html(rupiah(Number(data.other.final_total)));
            $("#discount").val(Number(data.other.discount_amount));
            $("#shipping").val(Number(data.other.shipping_charges));
            $("#taxPrice").val(Number(data.other.tax_amount));
            $("#other_price").val(Number(data.other.other_charges));
            playSound(domainpath + "/public/sound/beep-29");
        },

        cache: false,
        contentType: false,
        processData: false,
    });
    $("#holdmodal").modal("toggle");
}

function deletebill(bill, id) {
    var url = "/pos/product/delete-bill/" + bill;
    $.ajax({
        url: domain + url,
        type: "GET",
        data: "",
        success: function (data) {},
        cache: false,
        contentType: false,
        processData: false,
    });
    $("#cart" + id).remove();
    $(".pos-billing").trigger("change");
    playSound("/sound/remove");
    console.log(domain + url);
}

$("#holdbutton").on("click", function (e) {
    e.preventDefault();
    var holdinput = `<input type="hidden" name="hold" value="yes">  <h2 class="text-white text-center mt-2"><i class="fas fa-hand-paper"></i> Hold </h2>`;
    $("#holdtype").html(holdinput); 
    $("#paytransaction").trigger("click");  
    $("#billingmodal").modal("toggle");
});

$("form#cTransaction").on("submit", function (e) {  
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos/store",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml =
                        '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                        billing_empty +
                        "</li></ul>";

                    Swal.fire(
                        {
                            title: "Error", // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: close_lang,
                            showCancelButton: false,
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $("#openModal").on("click"); //this is when the form is in a modal
                            }
                        }
                    );
                    spinner.hide();
                } else {
                    Swal.fire({
                        icon: "success",
                        title: success_lang,
                        text: "" + "Data Transaksi berhasil ditambahkan",
                        showCloseButton: true
                    });
                   

                    if (data.message != "hold") {
                        var receipt = "";
                        var item = "";
                        var option = "";
                        if (data.change != 0 || data.change != "0") {
                            option =
                                "<tr><th>" +
                                change_total +
                                '</th><th class="text-end">' +
                                data.change +
                                "</th></tr>";
                        } else if (data.due != 0) {
                            option =
                                "<tr><th>" +
                                due_total +
                                '</th><th class="text-end">' +
                                data.due +
                                "</th></tr>";
                        } else {
                            option = "";
                        }

                        $.each(data.sell, function (index, value) {
                            item +=
                                `<tr><td>` +
                                index +
                                `</td><td>` +
                                value.product_name +
                                " - " +
                                value.variation_name +
                                `</td><td>` +
                                value.unit_price +
                                `</td><td>` +
                                value.qty +
                                `</td><td class="text-end">` +
                                value.subtotal +
                                `</td></tr>`;
                        });

                        receipt =
                            `<div class="row p-4 m-2">
                                <div class="col-12 text-center"> 
                                    <h3>` + data.store + `</h3>
                                    <p style="margin-top: -10px; font-size:14px;">` + data.address + `</p>
                                </div>
                            </div>
                            <div class="row p-4 mt-2">
                                <div class="col-6 text-left">
                                    <p style="font-size:12px;">No: ` + data.transaction.ref_no + `</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p style="font-size:12px;">` + date_lang + `: ` + moment(data.transaction.created_at).format("Y-MM-DD h:mm:ss") +`</p>
                                </div>
                                <hr style="margin-top:-15px;">
                                <div class="col-12">
                                    <table class="table table-borderless" style="font-size:12px">
                                        <thead>
                                            <tr>
                                                <th><b>#</b></th>
                                                <th><b>Item</b></th>
                                                <th><b>Price</b></th>
                                                <th><b>Qty</b></th>
                                                <th class="text-end"><b>` + subtotal_lang + `</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ` + item + `
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12"><table class="table" style="font-size:12px">
                                <tr><th>` +
                            subtotal_lang +
                            `</th><th class="text-end"><b>` +
                            data.subtotal +
                            `</b></th></tr>
                                <tr><th>` +
                            discount_lang +
                            `</th><th class="text-end">` +
                            data.transaction.discount_amount +
                            `%</th></tr>
                                <tr>
                                    <th>` +
                            tax_lang +
                            `</th> 
                                    <th class="text-end">` +
                            Number(data.transaction.tax_amount) +
                            `%</th>
                                </tr>
                                <tr>
                                    <th>` +
                            shipping_lang +
                            `</th> 
                                    <th class="text-end">` +
                            data.shipping +
                            `</th>
                                </tr>
                                <tr>
                                    <th>` +
                            other_lang +
                            `</th> 
                                    <th class="text-end">` +
                            data.other +
                            `</th>
                                </tr>
                                <tr>
                                    <th>` +
                            total_lang +
                            `</th> 
                                    <th class="text-end">` +
                            rupiah(data.transaction.final_total) +
                            `</th>
                                </tr>
                                <tr>
                                    <th>` +
                            payment_lang +
                            `</th> 
                                    <th class="text-end">` +
                            data.payment +
                            `</th>
                                </tr>
                                <tr>
                                    <th>` +
                            method_lang +
                            `</th> 
                                    <th class="text-end">` +
                            data.paymethod +
                            `</th>
                                </tr>
                                ` +
                            option +
                            `
                            </table>
                        </div>
                    </div>`;

                        $(".buttonprint").attr("id", data.transaction.id);
                        $("#paymodal").modal("toggle");
                        $("#receiptbody").html(receipt);
                        $("#receipt").modal("show");
                    }

                    // hold option
                    var holdinput =
                        `<h2 class="text-white text-center mt-2"><i class="fas fa-hand-paper"></i> ` +
                        hold_lang +
                        `</h2>`;
                    $("#holdtype").html(holdinput);

                    // cart
                    var cart = `<tr class="table-success cart0 d-none"> <input type="hidden" id="productID"> </tr>`;
                    $("#cartProduct").html(cart);

                    $("#discount").val(0);
                    $("#shipping").val(0);
                    $("#taxPrice").val(0);
                    $("#other_price").val(0);
                    $("#fixTotal").html(0);
                    $("#jumlahtotal").val("0");
                    // Payment Option
                    $("#on_pay").val(0);
                    $("#on_due").val(0);
                    $("#on_change").html(0);
                    $("#paymentprocess").html("");
                    $("#duepay").removeClass("d-none");
                    $("#changepay").addClass("d-none");

                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

function printcepeipt(id) {
    $.ajax({
        type: "GET",
        url: domainpath + "/pos/print/" + id,
        data: "",
    }).done(function (msg) {});
}

/**
 *  Playsound Function
 */
function playSound(filename) {
    var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
    var embedSource =
        '<embed hidden="true" autostart="true" loop="false" src="' +
        filename +
        '.mp3">';
    document.getElementById("sound").innerHTML =
        '<audio autoplay="autoplay">' + mp3Source + embedSource + "</audio>";
}
