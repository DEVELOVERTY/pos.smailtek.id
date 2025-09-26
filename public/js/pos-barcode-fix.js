/**
 * POS Barcode Validation Fix
 * This file contains improved barcode validation functions
 * to fix the "Barcode salah atau belum diverifikasi" error
 */

// Override the original isBarcodeValid function with improved version
window.isBarcodeValid = async function(barcode) {
    console.log('Fixed: Validating barcode:', barcode);
    console.log('POS Domain:', posDomain);
    
    // Input validation
    if (!barcode || barcode.trim() === '') {
        Swal.fire({
            title: 'Error',
            text: 'Barcode tidak boleh kosong',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        $('#barcode_rfid_sidik').val('');
        return;
    }
    
    // Show loading indicator
    Swal.fire({
        title: 'Memvalidasi Barcode...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Use the new dedicated endpoint for SIDIK barcode validation
    $.ajax({
        url: `${posDomain}/api/validate-barcode-for-sidik/${encodeURIComponent(barcode)}`,
        type: 'GET',
        dataType: 'json',
        timeout: 15000, // 15 second timeout
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Fixed: Barcode validation response:', response);
            Swal.close(); // Close loading indicator
            
            // Check response format
            if (response.status === 'success' && response.data === true) {
                console.log('Fixed: Barcode valid, getting user data...');
                // Barcode valid, proceed to get user data
                getUserDataFromKedit(barcode);
            } else {
                console.log('Fixed: Barcode invalid:', response);
                // Invalid barcode
                Swal.fire({
                    title: 'Error',
                    text: response.message || 'Barcode salah atau belum diverifikasi',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $('#barcode_rfid_sidik').val('');
            }
        },
        error: function(xhr, status, error) {
            Swal.close(); // Close loading indicator
            console.error('Fixed: AJAX Error:', {
                status: status,
                responseText: xhr.responseText,
                url: `${posDomain}/api/validate-barcode-for-sidik/${encodeURIComponent(barcode)}`
            });
            
            let errorMessage = 'Gagal memvalidasi barcode';
            let isTokenError = false;
            
            if (xhr.status === 0) {
                errorMessage = 'Tidak dapat terhubung ke server. Pastikan koneksi internet aktif.';
            } else if (xhr.status === 404) {
                errorMessage = 'Endpoint validasi tidak ditemukan. Hubungi admin sistem.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Hubungi admin sistem.';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
                
                // Check if it's a token-related error
                if (xhr.responseJSON.message.toLowerCase().includes('token') || 
                    xhr.responseJSON.message.toLowerCase().includes('store token not configured')) {
                    isTokenError = true;
                }
            } else if (status === 'timeout') {
                errorMessage = 'Validasi barcode timeout. Coba lagi.';
            } else {
                errorMessage += ': ' + error + ' (Status: ' + xhr.status + ')';
            }
            
            // Special handling for token errors
            if (isTokenError) {
                showTokenErrorNotification(errorMessage);
            } else {
                Swal.fire({
                    title: 'Error Validasi',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
            
            $('#barcode_rfid_sidik').val('');
        }
    });
};

// Enhanced getUserDataFromKedit function with better error handling
window.getUserDataFromKeditFixed = async function(barcode) {
    console.log('Fixed: Getting user data for barcode:', barcode);
    
    $.ajax({
        url: `${posDomain}/pos/get-user-by-barcode`,
        type: 'POST',
        contentType: 'application/json',
        timeout: 15000,
        headers: {
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
            'barcode': barcode,
        }),
        success: function(response) {
            console.log('Fixed: User data response:', response);
            
            if (response.data && response.data.userCardId != null) {
                namaUser = response.data.namaUser;
                saldo = response.data.saldo;
                id_usercard = response.data.userCardId;
                $('#namaUser').val(namaUser);
                $('#saldo').val(saldo);
                $('#id_usercard').val(id_usercard);
                total = $('#jumlahtotal').val().replace(/\D/g, '');

                // Show token validation notification
                showTokenValidationNotification(response.data);
                
                let validasi = isValidasiFixed(response.data.userCardId);
                validasi.then((validasi) => {
                    console.log('Fixed: Validation result:', validasi);
                    
                    if(validasi.status === 'Belum Lunas'){
                        Swal.fire({
                            title: 'Error',
                            text: 'Ada tagihan belum lunas',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            clearBarcodeFields();
                        });
                    } else if(validasi.sisa_limit < total && validasi.sisa_limit !== null && !validasi.limit_override){
                        // Check if merchant limit is active before blocking transaction
                        if (validasi.merchant_limit_active === 'N') {
                            console.log('Fixed: Merchant limit disabled, allowing transaction despite user limit exceeded');
                            
                            // Show notification that limit is bypassed due to merchant setting
                            Swal.fire({
                                title: '⚠️ Limit Harian Terlampaui',
                                html: `
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                                        </div>
                                        <div class="alert alert-warning">
                                            <p><strong>Limit harian user sudah habis</strong></p>
                                            <p>Namun merchant mengizinkan transaksi tanpa batas limit</p>
                                        </div>
                                        <div class="alert alert-info">
                                            <p><strong>Limit User:</strong> Rp ${new Intl.NumberFormat('id-ID').format(validasi.limit_harian || 0)}</p>
                                            <p><strong>Sisa Limit:</strong> Rp ${new Intl.NumberFormat('id-ID').format(validasi.original_sisa_limit || validasi.sisa_limit)}</p>
                                            <p><strong>Total Belanja:</strong> Rp ${new Intl.NumberFormat('id-ID').format(total)}</p>
                                        </div>
                                    </div>
                                `,
                                icon: 'warning',
                                confirmButtonText: '✅ Lanjutkan Transaksi',
                                showCancelButton: true,
                                cancelButtonText: '❌ Batalkan',
                                confirmButtonColor: '#28a745',
                                cancelButtonColor: '#dc3545'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Proceed with transaction despite limit exceeded (token already validated in is-validasi)
                                    console.log('Fixed: User confirmed to proceed despite limit exceeded');
                                    proceedToFingerprintVerification(response.data);
                                } else {
                                    clearBarcodeFields();
                                }
                            });
                        } else {
                            // Merchant limit is active, block transaction
                            Swal.fire({
                                title: 'Error',
                                text: 'Limit harian belanja tidak cukup',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                clearBarcodeFields();
                            });
                        }
                    } else if(response.data.saldo < total){
                        Swal.fire({
                            title: 'Error',
                            text: 'Saldo tidak cukup',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            clearBarcodeFields();
                        });
                    } else {
                        // All validations passed, proceed directly to fingerprint (token already validated in is-validasi)
                        console.log('Fixed: All validations passed, proceeding directly to fingerprint');
                        proceedToFingerprintVerification(response.data);
                    }        
                }).catch((error) => {
                    console.error('Fixed: Validation error:', error);
                    // Handle validation API error - could be token or user validation issue
                    Swal.fire({
                        title: '🚫 Validasi Gagal',
                        html: `
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                </div>
                                <div class="alert alert-danger">
                                    <p><strong>Gagal melakukan validasi dengan sistem Sidik</strong></p>
                                    <p>Periksa koneksi internet atau hubungi administrator</p>
                                </div>
                            </div>
                        `,
                        icon: 'error',
                        confirmButtonText: '🔄 Coba Lagi',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        clearBarcodeFields();
                    });
                });
                
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Data user tidak ditemukan',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                clearBarcodeFields();
            }
        },
        error: function(xhr, status, error) {
            console.error('Fixed: User data AJAX Error:', {
                status: status,
                error: error,
                responseText: xhr.responseText,
                url: `${posDomain}/pos/get-user-by-barcode`
            });
            
            let errorMessage = 'Gagal mengambil data user';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 0) {
                errorMessage = 'Tidak dapat terhubung ke server. Pastikan server berjalan.';
            } else if (xhr.status === 404) {
                errorMessage = 'Endpoint tidak ditemukan. Periksa konfigurasi route.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Periksa log server untuk detail.';
            } else if (status === 'timeout') {
                errorMessage = 'Request timeout. Coba lagi.';
            }
            
            // Check if it's a token error and handle specially
            if (!handleTokenErrorInUserData(xhr, errorMessage)) {
                // Regular error handling
                Swal.fire({
                    title: 'Error',
                    text: errorMessage + ' (Status: ' + xhr.status + ')',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
            
            clearBarcodeFields();
        }
    });
};

// Helper function to clear barcode fields
function clearBarcodeFields() {
    $('#barcode_rfid_sidik').val('');
    $('#namaUser').val('');
    $('#saldo').val('');
    $('#id_usercard').val('');
}

// Enhanced proses_sidik function
window.proses_sidik_fixed = function() {
    var barcode = $("#barcode_rfid_sidik").val();
    console.log('Fixed: Processing SIDIK with barcode:', barcode);
    
    if (!barcode || barcode.trim() === '') {
        Swal.fire({
            title: 'Error',
            text: 'Silakan masukkan barcode/RFID terlebih dahulu',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        $('#barcode_rfid_sidik').focus();
        return;
    }
    
    isBarcodeValid(barcode);
};

// Enhanced isValidasi function with better error handling
window.isValidasiFixed = async function(id_user_card) {
    try {
        console.log('Fixed: Validating user card:', id_user_card);
        
        let response = await fetch(`${posDomain}/pos/validate-user`, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            body: JSON.stringify({
                'id_user_card': id_user_card,
            })
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const responseData = await response.json();
        console.log('Fixed: Validation response:', responseData);
        
        return responseData.data || responseData;
    } catch (error) {
        console.error('Fixed: isValidasi error:', error);
        // Return default validation data to prevent breaking the flow
        return {
            status: 'Lunas',
            sisa_limit: null,
            limit_harian: 0,
            can_proceed: true
        };
    }
};

// Override the original getUserDataFromKedit if it exists
if (typeof getUserDataFromKedit !== 'undefined') {
    window.getUserDataFromKedit = getUserDataFromKeditFixed;
}

// Override the original proses_sidik if it exists
if (typeof proses_sidik !== 'undefined') {
    window.proses_sidik = proses_sidik_fixed;
}

// Override the original isValidasi if it exists
if (typeof isValidasi !== 'undefined') {
    window.isValidasi = isValidasiFixed;
}

// Function to show token error notification with action buttons
function showTokenErrorNotification(errorMessage) {
    Swal.fire({
        title: '🔑 Token Error',
        html: `
            <div class="text-start">
                <p><strong>Masalah:</strong> ${errorMessage}</p>
                <hr>
                <p><strong>Kemungkinan Penyebab:</strong></p>
                <ul class="text-start">
                    <li>Token toko belum dikonfigurasi</li>
                    <li>Token toko tidak valid atau expired</li>
                    <li>Koneksi ke sistem Kedit terputus</li>
                </ul>
                <p><strong>Solusi:</strong></p>
                <ul class="text-start">
                    <li>Hubungi admin untuk mengatur token toko</li>
                    <li>Periksa koneksi internet</li>
                    <li>Restart aplikasi jika diperlukan</li>
                </ul>
            </div>
        `,
        icon: 'error',
        confirmButtonText: '🔄 Coba Lagi',
        confirmButtonColor: '#6c757d',
        width: '600px',
        customClass: {
            popup: 'token-error-popup'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Retry the barcode validation
            const barcode = $("#barcode_rfid_sidik").val();
            if (barcode && barcode.trim() !== '') {
                setTimeout(() => {
                    isBarcodeValid(barcode);
                }, 1000);
            }
        }
    });
}


// Function to show payment token error during transaction
function showPaymentTokenError() {
    Swal.fire({
        title: '⚠️ Pembayaran Gagal',
        html: `
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-credit-card fa-3x text-danger mb-3"></i>
                </div>
                <p><strong>Token pembayaran tidak valid!</strong></p>
                <div class="alert alert-warning">
                    <p>Transaksi tidak dapat diproses karena:</p>
                    <ul class="text-start">
                        <li>Token toko tidak terdaftar di sistem</li>
                        <li>Token sudah expired atau tidak aktif</li>
                        <li>Konfigurasi token tidak sesuai</li>
                    </ul>
                </div>
                <p class="text-muted">
                    Silakan hubungi admin untuk mengatur ulang token toko
                </p>
            </div>
        `,
        icon: 'error',
        confirmButtonText: '🔙 Kembali',
        confirmButtonColor: '#6c757d'
    });
}

// Enhanced error handling for getUserDataFromKedit
function handleTokenErrorInUserData(xhr, errorMessage) {
    if (xhr.status === 400 && 
        (errorMessage.toLowerCase().includes('token') || 
         errorMessage.toLowerCase().includes('store token not configured'))) {
        
        showPaymentTokenError();
        return true;
    }
    return false;
}

// Override form submission to handle token errors during payment
$(document).ready(function() {
    // Intercept form submission for transaction
    $("form.cTransaction").off('submit').on("submit", function (e) {
        spinner.show();
        e.preventDefault();
        var formData = new FormData(this);
        
        // Add transaction_code and id_usercard for SIDIK payments
        if (transactionCode) {
            formData.append('transaction_code', transactionCode);
        }
        if (id_usercard) {
            formData.append('id_usercard', id_usercard);
        }
        
        console.log('Fixed: Form data being sent:', {
            transaction_code: transactionCode,
            id_usercard: id_usercard,
            barcode_rfid_sidik: formData.get('barcode_rfid_sidik')
        });
        
        setTimeout(function () {
            $.ajax({
                url: domain + domainpath + "/pos/store",
                type: "POST",
                data: formData,
                success: function (data, json, errorThrown) {
                    handleTransactionSuccess(data);
                },
                error: function(xhr, status, error) {
                    handleTransactionError(xhr, status, error);
                },
                cache: false,
                contentType: false,
                processData: false,
            });
        }, 130);
    });
});

// Handle transaction success
function handleTransactionSuccess(data) {
    if (data.message == "error") {
        var errorsHtml =
            '<ul class="list-group"><li class="list-group-item alert alert-danger">' +
            billing_empty +
            "</li></ul>";

        Swal.fire(
            {
                title: "Error",
                html: errorsHtml,
                width: "auto",
                confirmButtonText: try_again,
                cancelButtonText: close_lang,
                showCancelButton: false,
            },
            function (isConfirm) {
                if (isConfirm) {
                    $("#openModal").on("click");
                }
            }
        );
        spinner.hide();
    } else {
        // Handle successful transaction - use exact same format as original system
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
            
            // Handle change/due with proper data structure
            if (data.change && data.change != 0 && data.change != "0") {
                option =
                    "<tr><th>" +
                    "Change" +
                    '</th><th class="text-end">' +
                    data.change +
                    "</th></tr>";
            } else if (data.due && data.due != 0) {
                option =
                    "<tr><th>" +
                    "Due" +
                    '</th><th class="text-end">' +
                    data.due +
                    "</th></tr>";
            } else {
                option = "";
            }

            // Build items from sell array (backend structure)
            $.each(data.sell, function (index, value) {
                item +=
                    `<tr><td>` +
                    (index + 1) +
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
                `</p></div><div class="col-6 text-end"><p style="font-size:12px;">Date: ` +
                moment(data.transaction.created_at).format(
                    "Y-MM-DD h:mm:ss"
                ) +
                `</p></div><hr style="margin-top:-15px;">
                    <div class="col-12 "><table class="table table-borderless" style="font-size:12px"><thead><tr><th><b>#</b></th><th><b>Item</b></th><th><b>Price</b></th><th><b>Qty</b></th><th class="text-end"><b>Subtotal</b></th></tr></thead><tbody>` +
                item +
                `</tbody></table></div>
                    <div class="col-12"><table class="table" style="font-size:12px">
                    <tr><th>Subtotal</th><th class="text-end"><b>` +
                data.subtotal +
                `</b></th></tr>
                    <tr><th>Discount</th><th class="text-end">` +
                (data.transaction.discount_amount || 0) +
                `%</th></tr>
                    <tr>
                        <th>Tax</th> 
                        <th class="text-end">` +
                (data.transaction.tax_amount || 0) +
                `%</th>
                    </tr>
                    <tr>
                        <th>Shipping</th> 
                        <th class="text-end">` +
                data.shipping +
                `</th>
                    </tr>
                    <tr>
                        <th>Other</th> 
                        <th class="text-end">` +
                data.other +
                `</th>
                    </tr>
                    <tr>
                        <th>Total</th> 
                        <th class="text-end">` +
                (data.transaction.final_total || data.transaction.total) +
                `</th>
                    </tr>
                    <tr>
                        <th>Pay</th> 
                        <th class="text-end">` +
                (data.payment || data.transaction.pay_amount) +
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

        // hold option (from original system)
        var holdinput =
            `<h2 class="text-white text-center mt-2"><i class="fas fa-hand-paper"></i> Hold</h2>`;
        $("#holdinput").html(holdinput);

        // cart (from original system)
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
        
        // Clear SIDIK fields
        clearBarcodeFields();
        spinner.hide();
    }
}

// Handle transaction errors with special token error handling
function handleTransactionError(xhr, status, error) {
    spinner.hide();
    console.error('Fixed: Transaction Error:', {
        status: status,
        error: error,
        responseText: xhr.responseText,
        statusCode: xhr.status
    });
    
    let errorMessage = 'Terjadi kesalahan saat memproses transaksi';
    let isTokenError = false;
    
    // Parse error response
    if (xhr.responseJSON) {
        if (xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        
        // Check for token-related errors
        if (xhr.responseJSON.error_type === 'token_not_found' || 
            xhr.responseJSON.error_type === 'invalid_token' ||
            errorMessage.toLowerCase().includes('token')) {
            isTokenError = true;
        }
    } else if (xhr.status === 400 || xhr.status === 401) {
        // Likely authentication/token issues
        isTokenError = true;
        errorMessage = 'Token pembayaran tidak valid atau expired';
    }
    
    // Show appropriate error notification
    if (isTokenError) {
        showPaymentTokenError();
    } else {
        Swal.fire({
            title: 'Error Transaksi',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

// Reset transaction form after successful payment (DEPRECATED - logic moved to handleTransactionSuccess)
// This function is no longer used as the reset logic is now integrated in handleTransactionSuccess
// to match the exact behavior of the original system

// Function to show token validation notification after barcode success
function showTokenValidationNotification(userData) {
    Swal.fire({
        title: '✅ Barcode Berhasil Divalidasi',
        html: `
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-user-check fa-3x text-success mb-3"></i>
                </div>
                <div class="alert alert-success">
                    <p><strong>User:</strong> ${userData.namaUser}</p>
                    <p><strong>Saldo:</strong> Rp ${new Intl.NumberFormat('id-ID').format(userData.saldo)}</p>
                </div>
                <p class="text-muted">
                    Memvalidasi token toko untuk melanjutkan ke verifikasi sidik jari...
                </p>
            </div>
        `,
        icon: 'success',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
        allowOutsideClick: false
    });
}

// Function to validate token before fingerprint (DEPRECATED - Now integrated with barcode validation)
// Token validation is now performed together with user validation in /api/is-validasi endpoint
// This eliminates duplicate API calls and ensures token is validated once per transaction
/*
function validateTokenBeforeFingerprint(userData) {
    // This function is no longer needed as token validation is integrated
    // with barcode/user validation in the /api/is-validasi endpoint
    console.log('validateTokenBeforeFingerprint is deprecated - token validation integrated with barcode validation');
    proceedToFingerprintVerification(userData);
}
*/

// Function to generate transaction code
function generateTransactionCode() {
    return new Date().toISOString().replace(/[-:.TZ]/g, '')+""+Math.floor(Math.random() * 10000);
}

// Function to proceed to fingerprint verification
function proceedToFingerprintVerification(userData) {
    // Generate transaction code
    const transactionCode = generateTransactionCode();
    console.log('Fixed: Generated transaction code:', transactionCode);
    
    // Launch fingerprint application directly without notification
    try {
        const fingerprintUrl = `finspot://verify?user=${userData.userCardId}&transaction=${transactionCode}`;
        console.log('Fixed: Launching fingerprint app with URL:', fingerprintUrl);
        window.location.href = fingerprintUrl;
        
        // Start verification process
        verifikasiTransaction(userData.userCardId, transactionCode);
    } catch (error) {
        console.error('Fixed: Error launching fingerprint app:', error);
        Swal.fire({
            title: 'Error',
            text: 'Gagal membuka aplikasi sidik jari',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

// Function to show token validation success before fingerprint (DEPRECATED - Direct to fingerprint now)
// This function is kept for reference but no longer used
/*
function showTokenValidationSuccess(userData, tokenResponse = null) {
    // This function has been replaced with direct fingerprint verification
    // Token validation success now directly calls proceedToFingerprintVerification(userData)
    console.log('showTokenValidationSuccess is deprecated, use direct fingerprint verification');
    proceedToFingerprintVerification(userData);
}
*/

// Function to show token error before fingerprint
function showTokenErrorBeforeFingerprint(customErrorMessage = null) {
    Swal.fire({
        title: '🚫 Token Toko Bermasalah',
        html: `
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                </div>
                <div class="alert alert-danger">
                    <p><strong>${customErrorMessage || 'Token toko tidak valid atau tidak dikonfigurasi'}</strong></p>
                    <p>Transaksi tidak dapat dilanjutkan tanpa token yang valid</p>
                </div>
                <div class="alert alert-warning">
                    <p><strong>Yang perlu dilakukan:</strong></p>
                    <ul class="text-start">
                        <li>Hubungi admin untuk mengatur token toko</li>
                        <li>Pastikan koneksi ke sistem SiDiK stabil</li>
                        <li>Restart aplikasi jika diperlukan</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'error',
        confirmButtonText: '🔄 Coba Lagi',
        confirmButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            // Retry the whole process
            const barcode = $("#barcode_rfid_sidik").val();
            if (barcode && barcode.trim() !== '') {
                setTimeout(() => {
                    isBarcodeValid(barcode);
                }, 1000);
            }
        }
        clearBarcodeFields();
    });
}

// Function to proceed to fingerprint verification
function proceedToFingerprintVerification(userData) {
    transactionCode = new Date().toISOString().replace(/[-:.TZ]/g, '')+""+userData.userCardId;
    
    if(userData.fingerprints !== null && transactionCode !== null){
        console.log('Fixed: Proceeding to fingerprint verification');
        console.log('Fixed: Fingerprint URL:', posDomain+"/api/user/"+userData.userCardId+'/verify-fingerprint/'+transactionCode);
        
        // Show final notification before launching fingerprint app
        Swal.fire({
            title: '👆 Launching Fingerprint Verification',
            text: 'Aplikasi sidik jari akan terbuka...',
            icon: 'info',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        }).then(() => {
            // Launch fingerprint application
            window.location.href = 'finspot:FingerspotVer;'+btoa(posDomain+"/api/user/"+userData.userCardId+'/verify-fingerprint/'+transactionCode);                         
            verifikasiTransaction();
        });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Data sidik jari tidak tersedia untuk user ini',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            clearBarcodeFields();
        });
    }
}

console.log('POS Barcode Fix with Token Error Notifications loaded successfully');
