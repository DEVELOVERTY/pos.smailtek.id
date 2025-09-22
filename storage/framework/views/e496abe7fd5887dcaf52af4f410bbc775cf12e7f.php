<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
<link href="<?php echo e(asset('assets/vendors/summernote/summernote.min.css')); ?>" rel="stylesheet">
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
            <form id="" target="_blank" method="POST" action="<?php echo e(route('barcode.print')); ?>" enctype="multipart/form-data" class="col-md-12 col-12">
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
                                        <div class="col-12">
                                            <div class="table-responsive po_items">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table-1">
                                                        <thead>
                                                            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                                <td><?php echo e(__('produk.name')); ?></td>
                                                                <td><?php echo e(__('produk.print_label')); ?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="defaulth">
                                                            <?php $__currentLoopData = $data->purchase; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="items">
                                                                <td>
                                                                    <div class="col-md-10 form-group">
                                                                        <input type="hidden" name="variant_id[]" value="<?php echo e($p->variation_id); ?>">
                                                                        <input type="hidden" name="product_id[]" value="<?php echo e($p->product_id); ?>">
                                                                        <input type="text" class="form-control" required name="variant_name[]" value="<?php echo e($p->product->name); ?> - <?php echo e($p->variation->name); ?>" readonly>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-10 form-group">
                                                                        <input type="number" class="form-control" name="total[]" id="total" value="<?php echo e($p->quantity); ?>" required>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card discount_card">
                    <div class="card-content">
                        <div class="card-header">
                            <h4><?php echo e(__('produk.preview_label')); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row" id="barcodepreview">

                                        <div class="divider">
                                            <div class="divider-text"><?php echo e(__('produk.preview_label')); ?></div>
                                        </div>

                                        <div class="col-12 custom_barcode" id="option_barcode">

                                            <div class="row mb-5">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="product_name" id="product_name" checked="">
                                                        <label class="form-check-label" for="product_name"><?php echo e(__('produk.name')); ?></label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="variation_product" id="variation_product" checked="">
                                                        <label class="form-check-label" for="variation_product"><?php echo e(__('produk.variant_name')); ?></label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="barcode_number" id="barcode_number" checked="">
                                                        <label class="form-check-label" for="barcode_number"><?php echo e(__('general.barcode_code')); ?></label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="product_price" id="product_price" checked="">
                                                        <label class="form-check-label" for="product_price"><?php echo e(__('general.sell_price')); ?></label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="store_name" id="store_name" checked="">
                                                        <label class="form-check-label" for="store_name"><?php echo e(__('general.store')); ?></label>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4  barcodepreview">
                                            <p class="bproductname" style="font-size: 12px;"><b><?php echo e(__('produk.name')); ?></b> <b class="bvariation">- <?php echo e(__('produk.variant_name')); ?></b></p>
                                            <img class="product_barcode" id="barcode_img" src="data:image/png;base64, <?php echo e(DNS1D::getBarcodePNG('11223344', 'C39')); ?>" height="60" width="350" style="margin-top: -16px">
                                            <div class="row">
                                                <div class="col-6 bbarcode">
                                                    <div style="font-size: 12px;"><?php echo e(__('general.barcode_code')); ?> </div>
                                                </div>
                                                <div class="col-6 bprice">
                                                    <div style="font-size: 12px;"><?php echo e(__('general.sell_price')); ?> </div>
                                                </div>
                                                <div class="col-12 btoko">
                                                    <div style="font-size: 12px;"><?php echo e(__('general.store')); ?> </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-5">
                                            <button class="btn btn-primary float-end" type="submit"><?php echo e(__('produk.print_label')); ?></button>
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
<script src="<?php echo e(asset('assets/vendors/summernote/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script>
    $("#product_name").on("click", function() {
        var pname = $("input[name='product_name']:checked").length;
        if (pname == 0) {
            $(".bproductname").addClass("d-none");
        } else {
            $(".bproductname").removeClass("d-none");
        }
    });

    $("#variation_product").on("click", function() {
        var bvariation = $("input[name='variation_product']:checked").length;
        if (bvariation == 0) {
            $(".bvariation").addClass("d-none");
        } else {
            $(".bvariation").removeClass("d-none");
        }
    });

    $("#barcode_number").on("click", function() {
        var bbarcode = $("input[name='barcode_number']:checked").length;
        if (bbarcode == 0) {
            $(".bbarcode").addClass("d-none");
        } else {
            $(".bbarcode").removeClass("d-none");
        }
    });

    $("#product_price").on("click", function() {
        var bbarcode = $("input[name='product_price']:checked").length;
        if (bbarcode == 0) {
            $(".bprice").addClass("d-none");
            $(".btoko").removeClass("col-12");
            $(".btoko").addClass("col-6");
        } else {
            $(".bprice").removeClass("d-none");
            $(".btoko").removeClass("col-6");
            $(".btoko").addClass("col-12");
        }
    });

    $("#store_name").on("click", function() {
        var bbarcode = $("input[name='store_name']:checked").length;
        if (bbarcode == 0) {
            $(".btoko").addClass("d-none");
        } else {
            $(".btoko").removeClass("d-none");
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/product/purchase_label.blade.php ENDPATH**/ ?>