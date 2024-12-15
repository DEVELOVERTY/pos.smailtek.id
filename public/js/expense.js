$(document).ready(function () { 

    $("#summernote").summernote({
        tabsize: 2,
        height: 250,
    });

    $("select[name='category']").change(function () {
        var url = domainpath + "/pos-admin/expense/getSub/" + $(this).val();
        $("select[name='subcategory']").load(url);
        return false;
    }); 

   

    $("#amount").on("keyup",function() {
        var amount = $("#amount").val();
        $("#amount").val(formatRupiah(amount.toString())) 
        var amount = $("#amount").val(); 
    });


}); 