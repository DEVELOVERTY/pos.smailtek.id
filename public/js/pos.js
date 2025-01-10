moment.lang("id");

$(".select2").select2({
    width: 'resolve'  
});  

("use strict");
$(function () {
    ourProduct();
});

$(document).keypress(
    function(event){
      if (event.which == '13') {
        event.preventDefault();
      }
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

// Swicth Search
function swicthsearch()
{
    $("#seacrhform").removeClass("d-none");
    $("#choosecustomer").addClass("d-none");
    $(".swicthcustomer").removeClass("d-none");
    $(".swicthsearch").addClass("d-none");  
}

function swicthcustomer()
{
    $("#seacrhform").addClass("d-none");
    $("#choosecustomer").removeClass("d-none");
    $(".swicthcustomer").addClass("d-none");
    $(".swicthsearch").removeClass("d-none");
}

/**
 *  Seacrh Of Product
 */

$("#searchProduct").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#productData .productList").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

$("#searchProduct").keypress(function (e) {
    //Enter key
    if (e.which == 13) {
        return false;
    }
});

$("#searchProduct").scannerDetection({
    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 100, // it's not a barcode if a character takes longer than 100ms
    onComplete: function (barcode, qty) {
        $("#searchProduct").val(barcode);
        addCart(barcode);
    }, // main callback function
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
                    '<button id="' +
                    value.id +
                    '" onclick="addCart(this.id)" class="btn btn-sm btn-block text-white" style="background-color: #3c8dbc;"type="button"><i class="fas fa-cart-plus"></i> </button>';
                dataProduct +=
                    '<div class="col-lx-3 col-lg-3 col-md-4 col-sm-6  productList" id="productID-' +
                    value.index +
                    '"><div class="card"><div class="card-content"><div class="myproductbarcode d-none">' +
                    value.barcode +
                    '</div><img id="productImage" width="8vh;"   style="height:12vh;" src="' +
                    value.image +
                    '" class="card-img-top img-fluid" alt="' +
                    value.name +
                    '"></div><ul class="list-group list-group-flush text-center"><li class="list-group-item productName" style="font-size:15px; height:8vh; overflow:hidden" id="productName' +
                    value.id +
                    '">' +
                    value.name +
                    '</li><li class="list-group-item" id="productPrice">' +
                    value.price +
                    "</li>" +
                    addCart +
                    "</ul></div></div>";
            });
            document.getElementById("productData").innerHTML = dataProduct;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
}

/**
 *  Get Product By Category
 */
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
                    '<button id="' +
                    value.id +
                    '" onclick="addCart(this.id)" class="btn btn-sm btn-block text-white" style="background-color: #3c8dbc;"type="button"><i class="fas fa-cart-plus"></i> </button>';
                dataProduct +=
                    '<div class="col-lx-2 col-lg-2 col-md-4 col-sm-6 productList" id="productID-' +
                    value.index +
                    '"><div class="card"><div class="card-content"><div class="myproductbarcode d-none">' +
                    value.barcode +
                    '</div><img id="productImage" width="8vh;"   style="height:10vh;" src="' +
                    value.image +
                    '" class="card-img-top img-fluid" alt="' +
                    value.name +
                    '"></div><ul class="list-group list-group-flush text-center"><li class="list-group-item productName" style="font-size:15px; height:8vh; overflow:hidden" id="productName' +
                    value.id +
                    '">' +
                    value.name +
                    '</li><li class="list-group-item" id="productPrice">' +
                    value.price +
                    "</li>" +
                    addCart +
                    "</ul></div></div>";
            });
            document.getElementById("productData").innerHTML = dataProduct;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
}

$("select[name='category']").on("change", function () {
    var url = domainpath + "/pos/product/category/" + $(this).val();
    $.ajax({
        url: domain + url,
        type: "GET",
        data: "",
        success: function (data) {
            var addCart = "";
            var dataProduct = "";
            $.each(data.products, function (index, value) {
                addCart =
                    '<button id="' +
                    value.id +
                    '" onclick="addCart(this.id)" class="btn btn-sm btn-block text-white" style="background-color: #3c8dbc;"type="button"><i class="fas fa-cart-plus"></i> </button>';
                dataProduct +=
                    '<div class="col-lx-2 col-lg-2 col-md-4 col-sm-6  productList" id="productID-' +
                    value.index +
                    '"><div class="card"><div class="card-content"><div class="myproductbarcode d-none">' +
                    value.barcode +
                    '</div><img id="productImage" width="8vh;"   style="height:10vh;" src="' +
                    value.image +
                    '" class="card-img-top img-fluid" alt="' +
                    value.name +
                    '"></div><ul class="list-group list-group-flush text-center"><li class="list-group-item productName" style="font-size:15px; height:8vh; overflow:hidden" id="productName' +
                    value.id +
                    '">' +
                    value.name +
                    '</li><li class="list-group-item" id="productPrice">' +
                    value.price +
                    "</li>" +
                    addCart +
                    "</ul></div></div>";
            });
            document.getElementById("productData").innerHTML = dataProduct;
        },

        cache: false,
        contentType: false,
        processData: false,
    });
});

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
                        `" class="deletebil"  style="color:red; text-decoration:none;"> <i class="fa fa-times"></i></a></td>
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
    playSound(domainpath + "/public/sound/remove");
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
    document.getElementById("pay_modal_click").click();
    $(".non-sidik").show();
    $("#sidik").removeClass("active");
    $("#bank").removeClass("active");
    $("#cash").addClass("active");
    $("#card").removeClass("active");
    $("#paymentprocess").html("");


});

$(".payment_modal").on("keyup", "#on_pay", function () {
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
        toastr.success(success_lang, {
            timeOut: 5e3,
            closeButton: !0,
            debug: !1,
            newestOnTop: !0,
            progressBar: !0,
            positionClass: "toast-top-right",
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
    $("#sidik").removeClass("active");
    $(".non-sidik").show();


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
               `<div class="col-12 mt-3">
                    <table class="table">
                        <tr>
                            <th>
                                <label>No Rek</label>
                                <input type="text" class="form-control" value="" id="no_rek"  name="no_rek">
                            </th>
                            <th>
                                <label>Atas Name</label>
                                <input type="text" class="form-control" value="" id="an"  name="an">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <label>Nama Bank</label>
                                <select class="form-control" name="bank_id">` +
                                option +
                                `</select>
                            </th>
                        </tr>
                    </table>
               </div>`;
            $("#paymentprocess").html(form);
        },

        cache: false,
        contentType: false,
        processData: false,
    });
});

$("#sidik").on("click", function (e) {
    $("#bank").removeClass("active");
    $("#sidik").addClass("active");
    $("#card").removeClass("active");
    $("#cash").removeClass("active");
    $(".non-sidik").hide();
    payfull();
    var form = `<div class="col-12">
                    <table class="table">
                        <tr>
                            <th>
                                <label>Barcode/RFID Sidik</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" class="form-control" id="barcode_rfid_sidik" autocomplete="off" name="barcode_rfid_sidik">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="proses_sidik()"><i class="fas fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </th>
                            <th>
                                <label>Nama User</label>
                                <input type="hidden" id="id_usercard" name="id_usercard">
                                <input type="text" class="form-control" id="namaUser" name="namaUser" readonly>
                            </th>
                            <th>
                                <label>Saldo</label>
                                <input type="text" class="form-control" id="saldo" name="saldo" readonly>
                            </th>

                        </tr>
                    </table>
                </div>`;
    $("#paymentprocess").html(form);
});


$("#card").on("click", function (e) {
    $("#bank").removeClass("active");
    $("#cash").removeClass("active");
    $("#card").addClass("active");
    $("#sidik").removeClass("active");
    $(".non-sidik").show();

    var form = `<div class="col-12 mt-3">
                    <table class="table">
                        <tr>
                            <th>
                                <label>Card Number</label>
                                <input type="text" class="form-control" value="" id="card_number"  name="card_number">
                            </th>
                            <th>
                                <label>Card Holder Name</label>
                                <input type="text" class="form-control" value="" id="card_holder_name"  name="card_holder_name">
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <label>Card Transaction No.</label>
                                <input type="text" class="form-control" value="" id="card_transaction_number"  name="card_transaction_number">
                            </th>
                            <th>
                                <label>Card Type</label>
                                <select class="form-control" name="card_type"><option value="visa">Visa</option><option value="mastercard">Master Card</option><option value="visa">debit card</option></select>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <label>Month</label>
                                <input type="text" class="form-control" value="" id="card_month"  name="card_month">
                            </th>
                            <th>
                                <label>Year</label>
                                <input type="text" class="form-control" value="" id="card_year"  name="card_year">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <label>Card Security</label>
                                <input type="text" class="form-control" value="" id="card_security"  name="card_security">
                            </th> 
                        </tr>
                    </table>
                </div>`;
    $("#paymentprocess").html(form);
});

$("#cash").on("click", function (e) {
    $(".non-sidik").show();
    $("#sidik").removeClass("active");
    $("#bank").removeClass("active");
    $("#cash").addClass("active");
    $("#card").removeClass("active");
    $("#paymentprocess").html("");
});

$("#hold_modal").on("click", function () {
    $.ajax({
        url: domain + domainpath + "/pos/get-hold",
        type: "GET",
        data: "",
        success: function (data) {
            var holdData = "";
            $.each(data.transaction, function (index, value) {
                holdData +=
                    `<div class="col-6 col-lg-2 col-md-6">
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
                    `)"  style="color:red; text-decoration:none;"> <i class="fa fa-times"></i></a></td>
            </tr>`;
            });
            $("#cartProduct").html(billing);
            $("#cartProduct").append(option);
            $("#fixTotal").html(rupiah(Number(data.other.final_total)));
            $("#discount").val(Number(data.other.discount_amount));
            $("#shipping").val(Number(data.other.shipping_charges));
            $("#taxPrice").val(Number(data.other.tax_amount));
            $("#other_price").val(Number(data.other.other_charges));
            $("#jumlahtotal").val(rupiah(Number(data.other.final_total))) 
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
    playSound(domainpath + "/public/sound/remove");
    console.log(domain + url);
}

function payfull()
{ 
    var bill = $("#jumlahtotal").val();
    $("#on_pay").val(bill);
    $("#on_pay").trigger("keyup");

}

function duefull()
{
    var due = 0;
    $("#on_pay").val(due);
    $("#on_pay").trigger("keyup");
}


$("#holdbutton").on("click", function () {
    var holdinput = `<input type="hidden" name="hold" value="yes">`;
    $("#holdinput").html(holdinput);
    $("form.cTransaction").trigger("submit");
    $("#paymodal").modal("toggle");
});

$("form.cTransaction").on("submit", function (e) {
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
                    toastr.success(success_lang, {
                        timeOut: 5e3,
                        closeButton: !0,
                        debug: !1,
                        newestOnTop: !0,
                        progressBar: !0,
                        positionClass: "toast-top-right",
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
                            `<div class="row"><div class="col-12 text-center">
                                    <h3>` +
                            data.store +
                            `</h3><p style="margin-top: -10px; font-size:14px;">` +
                            data.address +
                            `</p></div></div>
                                <div class="row mt-2"><div class="col-6 text-left"><p style="font-size:12px;">No: ` +
                            data.transaction.ref_no +
                            `</p></div><div class="col-6 text-end"><p style="font-size:12px;">` +
                            date_lang +
                            `: ` +
                            moment(data.transaction.created_at).format(
                                "Y-MM-DD h:mm:ss"
                            ) +
                            `</p></div><hr style="margin-top:-15px;">
                                <div class="col-12 "><table class="table table-borderless" style="font-size:12px"><thead><tr><th><b>#</b></th><th><b>Item</b></th><th><b>Price</b></th><th><b>Qty</b></th><th class="text-end"><b>` +
                            subtotal_lang +
                            `</b></th></tr></thead><tbody>` +
                            item +
                            `</tbody></table></div>
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
                    $("#holdinput").html(holdinput);

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

function proses_sidik() {
    var barcode = $("#barcode_rfid_sidik").val();
    isBarcodeValid(barcode);
}



const apiDomain = "https://admin.sidikty.com/api";
const posDomain = window.location.protocol + "//" + window.location.hostname;
var transactionCode = null;
var _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content') || $('meta[name="csrf-token"]').attr('content');
var namaUser, saldo, id_usercard;
var total;

async function isBarcodeValid(barcode) {
    $.ajax({
        url: `${apiDomain}/is-barcode-valid`,
        type: 'POST',
        contentType: 'application/json',
        headers: {
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
            'barcode': barcode,
        }),
        success: function(response) {
            if (response.data.userCardId != null) {
                namaUser = response.data.namaUser;
                saldo = response.data.saldo;
                id_usercard = response.data.userCardId;
                $('#namaUser').val(namaUser);
                $('#saldo').val(saldo);
                $('#id_usercard').val(id_usercard);
                total = $('#jumlahtotal').val().replace(/\D/g, '');

                let validasi = isValidasi(response.data.userCardId);
                validasi.then((validasi) => {
                    if(validasi.status  === 'Belum Lunas'){
                        Swal.fire({
                            title: 'Error',
                            text: 'Ada tagihan belum lunas',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#barcode_rfid_sidik').val('');
                            $('#namaUser').val('');
                            $('#saldo').val('');
                            $('#id_usercard').val('');
                        });
                    } else if(validasi.sisa_limit < total && validasi.sisa_limit !== null){
                        Swal.fire({
                            title: 'Error',
                            text: 'Limit harian belanja tidak cukup',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#barcode_rfid_sidik').val('');
                            $('#namaUser').val('');
                            $('#saldo').val('');
                            $('#id_usercard').val('');
                        });
                    } else if(response.data.saldo < total){
                        Swal.fire({
                            title: 'Error',
                            text: 'Saldo tidak cukup',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#barcode_rfid_sidik').val('');
                            $('#namaUser').val('');
                            $('#saldo').val('');
                            $('#id_usercard').val('');
                        });
                    } else {
                        transactionCode = new Date().toISOString().replace(/[-:.TZ]/g, '')+""+response.userCardId;
                        if(response.fingerprints !== null && transactionCode !== null){
                            window.location.href = 'finspot:FingerspotVer;'+btoa(posDomain+"/"+response.userCardId+'/verify-fingerprint/'+barcode+'/transaction/'+transactionCode);
                            verifikasiTransaction();
                        }
                    }        
                });
                
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Barcode salah',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $('#barcode_rfid_sidik').val('');
            }
        }
    });
}

async function isValidasi(id_user_card) {
    let response = await fetch(`${apiDomain}/is-validasi`, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": _token
        },
        method: 'POST',
        body: JSON.stringify({
            'id_user_card': id_user_card,
        })
    });
    response = await response.json();

    return response.data;

}


let fingerprintCheckTimer = null;

async function verifikasiTransaction() {
    fingerprintCheckTimer = setInterval(checkverifikasiTransaction, 2000);   
}

async function checkverifikasiTransaction() {
    let response = await fetch(`${posDomain}/api/is-transaction-fingerprint-verified/`, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": _token
        },
        params: {
            'transaction_code': transactionCode,
        },
        method: 'GET',
    });
    response = await response.json();

    if (response.data && saveButton.disabled) {
        $('#savepay').show();
        clearInterval(fingerprintCheckTimer);
    }
}