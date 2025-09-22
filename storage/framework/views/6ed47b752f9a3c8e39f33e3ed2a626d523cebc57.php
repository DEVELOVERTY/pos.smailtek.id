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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Purchase")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('purchase.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.purchase')); ?></a>
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
                <form id="" method="POST" action="<?php echo e(route('return.store')); ?>" enctype="multipart/form-data" class="col-md-12 col-12">
                    <?php echo csrf_field(); ?>

                    <div class="card ">
                        <div class="card-header header-modal" >
                            <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form form-horizontal">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="control-label"><?php echo e(__('general.ref_no')); ?></label>
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="transaction_id" value="<?php echo e($data->id); ?>">
                                                    <input type="text" class="form-control" value="<?php echo e(old('ref_no')); ?>" id="product_sku" name="ref_no">
                                                    <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="table-responsive po_items">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="table-1">
                                                            <thead>
                                                                <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                                    <td><?php echo e(__('produk.name')); ?></td>
                                                                    <td><?php echo e(__('purchase.quantity')); ?></td>
                                                                    <td><?php echo e(__('purchase.return_have')); ?></td>
                                                                    <td><?php echo e(__('purchase.unit_cost')); ?> </td>
                                                                    <td><?php echo e(__('purchase.return_qty')); ?></td>
                                                                    <td width="10%"><?php echo e(__('purchase.return_subtotal')); ?></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="defaulth">
                                                                <?php $__currentLoopData = $data->purchase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($p->product->name); ?> - <?php echo e($p->variation->name); ?></td>
                                                                    <td><?php echo e($p->quantity); ?></td>
                                                                    <td><?php echo e($p->quantity_remaining($p->id)); ?> </td>
                                                                    <td><?php echo e(number_format($p->purchase_price)); ?></td>
                                                                    <td width="15%">
                                                                        <input type="hidden" name="p_id[]" value="<?php echo e($p->id); ?>">
                                                                        <input type="hidden" id="purchaseprice<?php echo e($p->id); ?>" value="<?php echo e($p->purchase_price); ?>">
                                                                        <input type="number" class="form-control qty_return" name="qty_return[]" id="<?php echo e($p->id); ?>" min="0" max="<?php echo e($p->quantity_remaining($p->id)); ?>" value="0">
                                                                        <span class="error-<?php echo e($p->id); ?> d-none" style="color: red;">* <?php echo e(__('purchase.max_qty')); ?></span>
                                                                    </td>
                                                                    <td width="10%">
                                                                        <input type="text" name="subtotal_return[]" class="form-control subtotalreturn" id="subtotal<?php echo e($p->id); ?>" value="0" readonly>
                                                                    </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <hr style="border: 1px solid black;">
                                                    <button class="btn btn-primary" type="submit"><?php echo e(__('general.create')); ?></button>
                                                    <h5 class="float-end"><?php echo e(__('purchase.items_total')); ?>: <span id="items_total"></span> </h5>
                                                    <input type="hidden" name="items_total" id="total_items">
                                                    <br><br>
                                                    <h5 class="float-end" style="margin-top: -20px"><?php echo e(__('purchase.net_total')); ?>: <span id="amount_total"></span> </h5>
                                                    <input type="hidden" name="amount_total" id="total_amount">
                                                </div>
                                            </div>
                                        </div>
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
    <script>
        $("#defaulth").on("change", ".qty_return", function(e) {
            var value = e.target.value;
            var max = e.target.max;
            var price = $("#purchaseprice" + e.target.id).val();
            var sbtl = parseInt(price) * parseInt(value);
            $("#subtotal" + e.target.id).val(formatRupiah(sbtl.toString()));

            if (parseInt(value) > parseInt(max)) {
                $(".error-" + e.target.id).removeClass("d-none");
                $("#" + e.target.id).val(max);

                var sbtl = parseInt(price) * parseInt(max);
                $("#subtotal" + e.target.id).val(formatRupiah(sbtl.toString()));
                return false;
            } else {
                $(".error-" + e.target.id).addClass("d-none");
            }
        });

        $(".po_items").on("change", function() {
            var totalItems = 0;
            var totalAmount = 0;
            $(this).find('input.qty_return').each(function() {
                totalItems += parseInt($(this).val());
            });
            $(this).find('input.subtotalreturn').each(function() {
                totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
            });
            $("#items_total").html(totalItems);
            $("#total_items").val(totalItems);
            $("#amount_total").html(formatRupiah(totalAmount.toString()));
            $("#total_amount").val(totalAmount);
        });
    </script>
    <?php $__env->stopSection(); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/return/po.blade.php ENDPATH**/ ?>