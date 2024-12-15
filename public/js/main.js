
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

/**
 *  DASHBOARD ATTENDANCE
 */
$("#checkint_attendance").on("click", function () {
    $.ajax({
        url: domain + domainpath + "/pos-admin/hrm/checkint",
        type: "GET",
        data: "",
        success: function (data) {
            if (data.message == "success") {
                toastr.success("Berhasil", data.success, {
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
                $("#checkint_attendance").addClass("d-none");
                $("#checkout_attendance").removeClass("d-none");
            }

            if (data.message == "min-check-int") {
                toastr.error(data.errors, {
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
            }

            if (data.message == "late") {
                toastr.error(data.errors, {
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
            }

            if (data.message == "employee-not-found") {
                toastr.error(data.errors, {
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
            }
        },

        cache: false,
        contentType: false,
        processData: false,
    });
    playSound("/sound/beep-29");
});

$("#checkout_attendance").on("click", function () {
    $.ajax({
        url: domain + domainpath + "/pos-admin/hrm/checkout",
        type: "GET",
        data: "",
        success: function (data) {
            if (data.message == "success") {
                toastr.success(data.success, {
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
                $("#checkout_attendance").addClass("d-none");
                $("#attendance_clear").removeClass("d-none");
            }

            if (data.message == "min") {
                toastr.error(data.errors, {
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
            }
        },

        cache: false,
        contentType: false,
        processData: false,
    });
    playSound("/sound/beep-29");
});

/**
 *  Update Profile
 */
 $("form#uProfile").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/auth/change-profile",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: "Error", // this will output "Error 422: Unprocessable Entity"
                            html: data.errors,
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Profile
$("form#uPassword").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/auth/change-profile",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: "Error", // this will output "Error 422: Unprocessable Entity"
                            html: data.errors,
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

$("form#uPassword").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/auth/change-profile",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                } else if (data.message == "password") {
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Category function
 */

// Create category
$("form#cCategory").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/category/category-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Category
$("form#uCategory").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/category/category-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Create Subcategory
$("form#cSubcategory").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/category/category-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Subcategory
$("form#uSubcategory").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/category/category-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Supplier
 */

// Create Supplier
$("form#cSupplier").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/supplier/supplier-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#address").val("");
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Supplier
$("form#uSupplier").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/supplier/supplier-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Customer
 */

// Create Customer
$("form#cCustomer").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/customer/customer-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Customer
$("form#uCustomer").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/customer/customer-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Expense Category function
 */

// Create Expense Category
$("form#cExca").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense-category/category-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Expense Category
$("form#uExca").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense-category/category-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Create Expense Sub Category
$("form#cExsub").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense-category/category-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Expense Sub Category
$("form#uExsub").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense-category/category-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Expense Category function
 */

// Create Expense Category
$("form#cExpense").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense/store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    $("#product_sku").val("");
                    $("#amount").val("");
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Expense Category
$("form#uExpense").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/expense/store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});
/**
 *  Brand
 */

// Create Brand
$("form#cBrandForm").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/brand-store/create",
            type: "POST",
            data: formData,
            success: function (data) {
                toastr.success(success, {
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
                $("#code").val("");
                $("#detail").val("");
                spinner.hide();
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Brand
$("form#uBrandForm").submit(function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/brand-store/update",
            type: "POST",
            data: formData,
            success: function (data) {
                toastr.success(success, {
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
                spinner.hide();
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Unit
 */

// Create Unit
$("form#cUnit").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/unit-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#code").val("");
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Unit
$("form#uUnit").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/unit-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Box
 */

// Create Box
$("form#cBox").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/box-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#code").val("");
                    $("#detail").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Box
$("form#uBox").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/box-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Taxrate
 */

// Create
$("form#cTax").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        console.log(try_again)
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/taxrate-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#code").val("");
                    $("#taxrate").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update
$("form#uTax").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/taxrate-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Printer
 */

// Change Type Option
$("select[name='type']").on("change", function () {
    if ($(this).val() == "online") {
        $("#label-url").removeClass("d-none");
        $("#form-url").removeClass("d-none");
    } else {
        $("#label-url").addClass("d-none");
        $("#form-url").addClass("d-none");
    }
});

// Create
$("form#cPrinter").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/printer-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#path").val("");
                    $("#char_per_line").val("");
                    $("#ip_address").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update
$("form#uPrinter").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/printer-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Country
 */
$(".edit_country").on("click", ".country", function () {
    country_modal = $(this).closest(".edit_country");
    $("#country_id").val(country_modal.find("#ci").html());
    $("#country_name").val(country_modal.find("#cn").html());
    document.getElementById("update_c").click();
});

/**
 *  Timezone
 */
$(".edit_timezone").on("click", ".timezone", function () {
    country_modal = $(this).closest(".edit_timezone");
    $("#timezone_id").val(country_modal.find("#ti").html());
    $("#timezone_name").val(country_modal.find("#tn").html());
    document.getElementById("update_t").click();
});

/**
 *  Currcency
 */
$(".edit_currency").on("click", ".currency", function () {
    country_modal = $(this).closest(".edit_currency");
    $("#currency_id").val(country_modal.find("#ci").html());
    $("#currency_name").val(country_modal.find("#cn").html());
    $("#currency_code").val(country_modal.find("#cd").html());
    $("#currency_c").val(country_modal.find("#cr").html())
    $("#currency_cd").val(country_modal.find("#cdd").html())
    document.getElementById("update_c").click();
});

/**
 *  Permission
 */
$(".edit_permission").on("click", ".permission", function () {
    country_modal = $(this).closest(".edit_permission");
    $("#permission_id").val(country_modal.find("#pi").html());
    $("#permission_name").val(country_modal.find("#pn").html());
    document.getElementById("update_p").click();
});

/**
 *  Bank
 */
$(".bank").on("click", ".updatebank", function () {
    bank = $(this).closest(".bank");
    $("#bank_id").val(bank.find("#ci").html());
    $("#bank_name").val(bank.find("#cn").html());
    $("#bank_code").val(bank.find("#cd").html());
    document.getElementById("update_c").click();
});

/**
 *  Designation
 */

// Create Designation
$("form#cDesignation").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/designation-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Designation
$("form#uDesignation").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/designation-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Allowance
 */

// Create Allowance
$("form#cAllowance").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/allowance-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#amount").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Allowance
$("form#uAllowance").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/allowance-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  CUTTING SALARY
 */

// Create Allowance
$("form#cCutting").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/cutting-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#amount").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Allowance
$("form#uCutting").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/hrm/cutting-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Get Method Form
 */

$("select[name='payment_method']").change(function () {
    var method = $(this).val();

    if (method == "bank_transfer") {
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
                    `<div class="col-md-6 form-group"><label>No Rek</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="no_rek"  name="no_rek"></div> </div>
                            <div class="col-md-6 form-group"><label>Atas Nama</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="an"  name="an"></div> </div>
                            <div class="col-md-6 form-group"><label>Nama Bank</label><div class="input-group mb-3"><select class="form-control" name="bank_id">` +
                    option +
                    `</select></div> </div>
                            <div class="col-md-6 form-group"><label>Jumlah Pembayaran</label> <div class="input-group mb-3"> <input type="text" class="form-control"  value="0" id="payment_amount" value="0" name="payment_amount"> </div> </div> `;
                $("#paymentprocess").html(form);
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    } else if (method == "cash") {
        var form = `<div class="col-md-6 form-group"><label>Jumlah Pembayaran</label> <div class="input-group mb-3"> <input type="text" class="form-control"  value="0" id="payment_amount" value="0" name="payment_amount"> </div> </div> `;
        $("#paymentprocess").html(form);
    } else if (method == "card") {
        var form = `<div class="col-md-6 form-group"><label>Card Number</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_number"  name="card_number"></div> </div>
                <div class="col-md-6 form-group"><label>Card Holder Name</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_holder_name"  name="card_holder_name"></div> </div>
                <div class="col-md-6 form-group"><label>Card Transaction No.</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_transaction_number"  name="card_transaction_number"></div> </div>
                <div class="col-md-6 form-group"><label>Card Type</label><div class="input-group mb-3"><select class="form-control" name="card_type"><option value="visa">Visa</option><option value="mastercard">Master Card</option><option value="visa">debit card</option></select></div> </div>
                <div class="col-md-6 form-group"><label>Month</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_month"  name="card_month"></div> </div>
                <div class="col-md-6 form-group"><label>Year</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_year"  name="card_year"></div> </div>
                <div class="col-md-6 form-group"><label>Card Security</label><div class="input-group mb-3"><input type="text" class="form-control" value="" id="card_security"  name="card_security"></div> </div>
                <div class="col-md-6 form-group"><label>Jumlah Pembayaran</label> <div class="input-group mb-3"> <input type="text" class="form-control"  value="0" id="payment_amount" value="0" name="payment_amount"> </div> </div> `;
    }

    $("#paymentprocess").html(form);
});

/**
 *  Setting
 */
$("form#uSetting").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/settings-store",
            type: "POST",
            data: formData,
            success: function (data) {
                toastr.success(success, {
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
                spinner.hide();
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Store
 */

// Create
$("form#cStore").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/store/store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#code").val("");
                    $("#email").val("");
                    $("#phone").val("");
                    $("#zip_code").val("");
                    $("#tax").val(0);
                    $("#zakat").val(0);
                    $("#address").val("");
                    $("#footer_text").val("");
                    $("#gst").val("");
                    $("#vat").val("");
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update
$("form#uStore").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/store/store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Users
 */

// Create Users
$("form#cUsers").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/user-manager/user-store",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#email").val("");
                    $("#password").val("");
                    spinner.hide();
                }
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Users
$("form#uUsers").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/user-manager/user-supdate",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Employee
 */

// Create Employee
$("form#cEmployee").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/employee/employee-store/create",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    $("#date_birth").val("");
                    $("#salary").val("");
                    $("#phone").val("");

                    $("#address").val("");
                    $("#about").val("");
                    spinner.hide();
                }
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

// Update Users
$("form#uEmployee").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/employee/employee-store/update",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  HRM SETTING
 */

$("form#uHrm").on("submit", function (e) {
    spinner.show();
    e.preventDefault();
    var formData = new FormData(this);
    setTimeout(function () {
        $.ajax({
            url: domain + domainpath + "/pos-admin/system/hrm-store",
            type: "POST",
            data: formData,
            success: function (data, json, errorThrown) {
                if (data.message == "error") {
                    var errorsHtml = "";
                    $.each(data.errors, function (index, value) {
                        errorsHtml +=
                            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
                            value +
                            "</li></ul>";
                    });
                    Swal.fire(
                        {
                            title: data.message + " " + data.status, // this will output "Error 422: Unprocessable Entity"
                            html: errorsHtml,
                            width: "auto",
                            confirmButtonText: try_again,
                            cancelButtonText: "Cancel",
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
                    toastr.success(success, {
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
                    spinner.hide();
                }
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    }, 130);
});

/**
 *  Update Margin Percetace
 */

const rupiah = (total) => {
    return new Intl.NumberFormat({
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(total);
};

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^.\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "," : "";
        rupiah += separator + ribuan.join(",");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? rupiah : "";
}

$(".variant-0").on("keyup", function (e) {
    var p_price = $(this).find("input#purchase_price").val();
    var s_price = $(this).find("input#selling_price").val();
    var countPercentase =
        (parseInt(s_price.replace(/[^0-9]/g, "").toString()) /
            parseInt(p_price.replace(/[^0-9]/g, "").toString())) *
            100 -
        100;
    $(this).find("input#margin").val(countPercentase.toFixed(0));
});

$(".single_product").on("keyup", function (e) {
    var p_price = $(this).find("input#p_price").val();
    var s_price = $(this).find("input#s_price").val();

    $(this).find("input#p_price").val(formatRupiah(p_price));
    $(this).find("input#s_price").val(formatRupiah(s_price));
    var countPercentase =
        (parseInt(s_price.replace(/[^0-9]/g, "").toString()) /
            parseInt(p_price.replace(/[^0-9]/g, "").toString())) *
            100 -
        100;
    $(this).find("input#margin").val(countPercentase.toFixed(0));
});

$("body").on("change", ".variant", function () {
    var p_price = $(this).find("input#purchase_price").val();
    var s_price = $(this).find("input#selling_price").val();
    $(this).find("input#purchase_price").val(formatRupiah(p_price));
    $(this).find("input#selling_price").val(formatRupiah(s_price));
    var countPercentase =
        (parseInt(s_price.replace(/[^0-9]/g, "").toString()) /
            parseInt(p_price.replace(/[^0-9]/g, "").toString())) *
            100 -
        100;
    $(this).find("input#margin").val(countPercentase.toFixed(0));
});

$("#get_sku").on("click", function (length) {
    $("#product_sku").val(getSku(6));
});

$("#getrest").on("click", function (length) {
    $("#restapi").val(getSku(12));
});

function getSku(length) {
    var result = [];
    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result.push(
            characters.charAt(Math.floor(Math.random() * charactersLength))
        );
    }
    return result.join("");
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
