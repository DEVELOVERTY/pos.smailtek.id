$(document).ready(function () {
    $(".dropify").dropify();

    $("#summernote").summernote({
        tabsize: 2,
        height: 250,
    });

    $("select[name='category']").change(function () {
        var url = domainpath + "/pos-admin/product/getSub/" + $(this).val();
        $("select[name='subcategory']").load(url);
        return false;
    });

    $("select[name='type']").change(function () {
        if ($(this).val() == "single") {
            $("#variable").addClass("d-none");
            $("#single").removeClass("d-none");
        } else if ($(this).val() == "variable") {
            $("#single").addClass("d-none");
            $("#variable").removeClass("d-none");
        } else if ($(this).val() == "Pilih Type") {
            $("#variable").addClass("d-none");
            $("#single").addClass("d-none");
        }
    });

    $("body").on("click", ".delete_variant", function () {
        $(this).parents(".variant").remove();
    });
});

$("select[name='variation']").change(function (e) {
    if ($(this).val() != "0") {
        var url = domainpath + "/pos-admin/product/getVariant/" + $(this).val();
        spinner.show();
        e.preventDefault();
        setTimeout(function () {
            $.ajax({
                url: domain + url,
                type: "GET",
                data: "",
                success: function (data, json, errorThrown) {
                    var dataContent = "";
                    var buttonContent = "";
                    $.each(data.variant, function (index, value) {
                        if (index == 0) {
                            buttonContent = `<button type="button" class="btn btn-sm btn-success text-white" onclick="add_variant()"><i class="fas fa-plus-circle"></i></button>`;
                        } else {
                            buttonContent =
                                '<button type="button" class="btn btn-sm btn-danger" id="' +
                                index +
                                '" onclick="delete_variant(this.id)"><i  class="fas fa-minus-circle"></i></button>';
                        }

                        dataContent +=
                            '<tr class="variant-' +
                            index +
                            '" onchange="changePercentase(this.id)" id="' +
                            index +
                            '"> <td> <div class="col-md-10 form-group"> <input type="hidden" name="variation_id[]"> <input type="hidden" name="value_id[]" value="' +
                            value.id +
                            '"><input type="text" class="form-control" required name="value[]" id="value" value="' +
                            value.name +
                            '"  readonly></div></td> <td><div class="col-md-10 form-group"><input type="text" class="form-control" name="sku[]" id="sku"></div></td> <td><div class="col-md-10 form-group"><input type="text" class="form-control" name="purchase_price[]" id="purchase_price" required></div></td> <td> <div class="col-md-10 form-group"><input type="number" class="form-control" name="margin[]" id="margin" required></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="selling_price[]" id="selling_price" required ></div>  </td><td><div class="col-md-10 form-group"><input type="file" class="form-control" name="im[]" id="image"></div></td><td>' +
                            buttonContent +
                            "</td></tr>";
                    });
                    $(".variant-0").remove();
                    $(".variant-001").before(dataContent)
                    spinner.hide();
                },

                cache: false,
                contentType: false,
                processData: false,
            });
        }, 100);
    }
});

$(".variant-0").on("change", function (e) {
    pp = formatRupiah($(this).find("#purchase_price").val());
    $(this).find("#purchase_price").val(pp);
    sp = formatRupiah($(this).find("#selling_price").val());
    $(this).find("#selling_price").val(sp);
});

/**
 *  Save Product Data Function
 */

function add_variant() {
    var cloning = `<tr class="variant"><td><div class="col-md-10 form-group"><input type="hidden" name="variation_id[]"><input type="hidden" name="value_id[]"><input type="text" class="form-control" required name="value[]" id="value"  ></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="sku[]" id="sku"></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="purchase_price[]" id="purchase_price" required></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="margin[]" id="margin" required></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="selling_price[]" id="selling_price" required ></div></td><td><div class="col-md-10 form-group"><input type="file" class="form-control" name="im[]" id="image" ></div></td><td><button type="button" class="btn btn-sm btn-danger delete_variant"><i  class="fas fa-minus-circle"></i></button></td></tr>`;
    $(".variant-001").before(cloning);
}

function delete_variant(id) {
    $(".variant-" + id).remove();
}

function changePercentase(id) {
    var id = $(".variant-" + id);
    var p_price = id.find("input#purchase_price").val();
    var s_price = id.find("input#selling_price").val();

    id.find("input#purchase_price").val(formatRupiah(p_price));
    id.find("input#selling_price").val(formatRupiah(s_price));

    var countPercentase =
        (parseInt(s_price.replace(/[^0-9]/g, "").toString()) / parseInt(p_price.replace(/[^0-9]/g, "").toString())) * 100 -  100;
    id.find("input#margin").val(countPercentase.toFixed(0));
}
