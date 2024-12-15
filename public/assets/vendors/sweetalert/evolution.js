var confirmation = $("#are_you_sure").val();
var warning = $("#delete_warning").val();
var yes_sure = $("#yes_sure").val();

$(".deletebutton").on("click", function(e) {
    e.preventDefault();
    const href = $(this).attr("href");
    Swal.fire({
        title: confirmation,
        text: warning,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: yes_sure
    }).then(result => {
        if (result.value) {
            document.location.href = href;
        }
    });
});
