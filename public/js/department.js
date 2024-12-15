$(".edit_department").on("click", ".department", function () {
    department_modal = $(this).closest(".edit_department");
    $("#department_id").val(department_modal.find("#di").html());
    $("#department_name").val(department_modal.find("#dn").html());
    document.getElementById("update_d").click();
   // $("#update_department").modal();
});
