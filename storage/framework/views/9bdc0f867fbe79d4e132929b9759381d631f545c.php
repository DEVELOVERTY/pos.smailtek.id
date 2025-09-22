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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Produk")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('product.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.product')); ?></a>
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
            <form id="" method="POST" action="<?php echo e(route('store.opening','create')); ?>" enctype="multipart/form-data" class="col-md-12 col-12">
                <?php echo csrf_field(); ?> 
                <div class="card ">
                    <div class="card-header header-modal">
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
                                                <input type="hidden" name="product_id" value="<?php echo e($data->id); ?>">
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
                                                                <td><?php echo e(__('purchase.quantity')); ?> - <?php echo e(__('produk.open_stock')); ?> </td>
                                                                <td><?php echo e(__('general.purchase_price')); ?> </td>
                                                                <td width="10%"><?php echo e(__('general.subtotal')); ?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="defaulth">
                                                            <?php
                                                            $subtotal = 0;
                                                            ?>
                                                            <?php $__currentLoopData = $data->variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                            $subtotal += $v->purchase_price;
                                                            ?>
                                                            <tr>
                                                                <td><?php echo e($v->product->name ?? ''); ?> - <?php echo e($v->name); ?></td>
                                                                <td>
                                                                    <input type="hidden" name="variation_id[]" id="variationID" value="<?php echo e($v->id); ?>">
                                                                    <input type="number" class="form-control qty_opening" name="qty_opening[]" id="<?php echo e($v->id); ?>" min="1" value="1">
                                                                </td>
                                                                <td><?php echo e(number_format($v->purchase_price)); ?></td>
                                                                <td width="15%">
                                                                    <input type="hidden" id="pricing-<?php echo e($v->id); ?>" name="pricing[]" value="<?php echo e($v->purchase_price); ?>">
                                                                    <input type="text" name="opening_subtotal[]" class="form-control opening_subtotal" id="subtotal<?php echo e($v->id); ?>" value="<?php echo e(number_format($v->purchase_price)); ?>" readonly>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <hr style="border: 1px solid black;">
                                                <button class="btn btn-primary" type="submit"><?php echo e(__('produk.add_stok')); ?></button>
                                                <h5 class="float-end"><?php echo e(__('purchase.items_total')); ?>: <span id="items_total"><?php echo e(count($data->variant)); ?></span> </h5>
                                                <br><br>
                                                <h5 class="float-end" style="margin-top: -20px"><?php echo e(__('purchase.net_total')); ?>: <span id="amount_total"> <?php echo e(number_format($subtotal)); ?> </span> </h5>
                                                <input type="hidden" name="amount_total" id="total_amount" value="<?php echo e($subtotal); ?>">
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
    $("#defaulth").on("change", ".qty_opening", function(e) {
        var value = e.target.value;
        var id = e.target.id;
        var price = $("#pricing-" + id).val();
        var sbtl = parseInt(price) * parseInt(value);
        console.log(value, price, sbtl)
        $("#subtotal" + id).val(formatRupiah(sbtl.toString()));
    });

    $(".po_items").on("change", function() {
        var totalItems = 0;
        var totalAmount = 0;
        $(this).find('input.qty_opening').each(function() {
            totalItems += parseInt($(this).val());
        });
        $(this).find('input.opening_subtotal').each(function() {
            totalAmount += parseInt($(this).val().replace(/[^0-9]/g, '').toString());
        });
        $("#items_total").html(totalItems);
        $("#amount_total").html(formatRupiah(totalAmount.toString()));
        $("#total_amount").val(totalAmount);
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/product/open_stock.blade.php ENDPATH**/ ?>