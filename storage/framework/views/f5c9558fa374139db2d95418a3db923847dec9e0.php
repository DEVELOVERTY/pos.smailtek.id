<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
<link href="<?php echo e(asset('assets/vendors/summernote/summernote.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/select3/dist/css/select2.min.css')); ?>" />
<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Adjustment")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('adjustment.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.list_adjs')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\ValidationComponent::class, []); ?>
<?php $component->withName('admin.validation-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>

        <div class="row match-height">
            <form id="" method="POST" action="<?php echo e(route('adjustment.store')); ?>" enctype="multipart/form-data" class="col-md-12 col-12">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.ref_no')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="<?php echo e(old('ref_no')); ?>" id="product_sku" name="ref_no">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.date')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="<?php echo e(old('transaction_date', date('Y-m-d H:i'))); ?>" id="transaction_date" name="transaction_date" readonly>
                                                <button class="btn btn-primary" type="button" id="transaction_date"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.type')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="type" id="type">
                                                <option value=""><?php echo e(__('adjustment.choose_type')); ?></option>
                                                <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($t); ?>" <?php if($t==old('type')): ?> selected <?php endif; ?>><?php echo e($values); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="table-responsive po_items">
                                            <div class="content-center">
                                                <div class="input-group mb-3">
                                                    <select id='selProduct' required name='getProduct' class='form-control' style='width: 100%;' readonly>
                                                        <option value=''><?php echo e(__('produk.choose_product')); ?> </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="table-1">
                                                    <thead>
                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                            <td><?php echo e(__('produk.name')); ?></td>
                                                            <td><?php echo e(__('purchase.quantity')); ?></td>
                                                            <td><?php echo e(__('purchase.unit_cost')); ?></td>
                                                            <td><?php echo e(__('general.subtotal')); ?></td>
                                                            <td><i class="fa fa-trash"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="defaulth">

                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr style="border: 1px solid black;">
                                            <h5 class="float-end"><?php echo e(__('purchase.items_total')); ?> : <span id="items_total"></span> </h5>
                                            <input type="hidden" name="items_total" id="total_items">
                                            <br><br>
                                            <h5 class="float-end" style="margin-top: -20px"><?php echo e(__('purchase.net_total')); ?> : <span id="amount_total"></span> </h5>
                                            <input type="hidden" name="amount_total" id="total_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card discount_card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('adjustment.amount_recovered')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="<?php echo e(old('total_amount_recovered', 0)); ?>" id="total_amount_recovered" name="total_amount_recovered">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.note')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea class="form-control" name="additional_note"><?php echo e(old('additional_note')); ?></textarea>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;">
                                    <button class="btn btn-primary" type="submit"><?php echo e(__('general.add')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/summernote/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/select3/dist/js/select2.full.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
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

                        dataContent +=
                            '<tr class="items"><td><div class="col-md-10 form-group"><input type="hidden" name="variant_id[]" value="' +
                            product.id +
                            '"><input type="hidden" name="product_id[]" value="' +
                            product.pid +
                            '"><input type="text" class="form-control" required name="variant_name[]"  value="' +
                            product.name +
                            '"  readonly></div></td><td><div class="col-md-10 form-group"><input type="number" class="form-control" name="qty[]" id="qty" value="1" min="1" max="' + product.stock + '" required><span class="error d-none" style="color: red;">* Qty Tersedia ' + product.stock + '</span></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="unit_cost[]" value="' +
                            formatRupiah(product.p_price) +
                            '" id="unit_cost" readonly ></div></td><td><div class="col-md-10 form-group"><input type="text" class="form-control" name="line_total[]" id="line_total" value="' +
                            formatRupiah(product.p_price) +
                            '" readonly></div></td>    <td><button type="button" class="btn btn-sm btn-danger delete_items"><i  class="fas fa-minus-circle"></i></button></td></tr>';
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
            totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
        });
        $("#items_total").html(totalItems);
        $("#total_items").val(totalItems);
        $("#amount_total").html(formatRupiah(totalAmount.toString()));
        $("#total_amount").val(totalAmount);
        $('.items').trigger("keyup");
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
        });
    });



    $("body").on("change", ".items", function(e) {

        var value = e.target.value;
        var max = e.target.max;
        var s_price = $(this).find("input#unit_cost").val();
        var qty = $(this).find("input#qty").val();
        var lineTotal = parseInt(s_price.replace(/[^0-9]/g, '').toString()) * qty;
        $(this).find("input#line_total").val(formatRupiah(lineTotal.toString()));

        if (parseInt(value) > parseInt(max)) {
            $(this).find(".error").removeClass("d-none");

            var lineTotal = parseInt(s_price.replace(/[^0-9]/g, '').toString()) * parseInt(max);
            $(this).find("input#line_total").val(formatRupiah(lineTotal.toString()));
            $(this).find("input#qty").val(max);
            $(".po_items").trigger("change");
            $(".discount_card").trigger("change");
            return false;
        } else {
            $(this).find(".error").addClass("d-none");
        }
        $(".po_items").trigger("change");
        $(".discount_card").trigger("change");
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


    $("#total_amount_recovered").on("keyup", function() {
        var recovered = $("#total_amount_recovered").val();
        $("#total_amount_recovered").val(formatRupiah(recovered.toString()));
        var recovered = $("#total_amount_recovered").val();
    })
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/adjustment/create.blade.php ENDPATH**/ ?>