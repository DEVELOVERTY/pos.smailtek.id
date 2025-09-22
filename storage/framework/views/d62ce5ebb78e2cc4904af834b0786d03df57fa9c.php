<!DOCTYPE html>
<html lang="id"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/icon.png')); ?>" type="image/x-icon">
    <title><?php echo e($page); ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/slick/slick.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/slick/slick-theme.min.css')); ?>" />

    <link href="<?php echo e(asset('assets/vendors/icons/feather.css')); ?>" rel="stylesheet" type="text/css">

    <link href="<?php echo e(asset('assets/vendors/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/toastr/toastr.min.css')); ?>">
    <link href="<?php echo e(asset('assets/mobile/css/style.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/select3/dist/css/select2.min.css')); ?>" />
</head>

<body class="fixed-bottom-bar">
    <div id="loader"></div>
    <div id="sound"></div>
    <div id="addcartlang" class="d-none"><?php echo e(__('pos.add_cart')); ?></div>
    <?php if (isset($component)) { $__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\LangComponent::class, []); ?>
<?php $component->withName('admin.lang-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d)): ?>
<?php $component = $__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d; ?>
<?php unset($__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d); ?>
<?php endif; ?>
    <form method="POST" id="cTransaction">
        <?php echo csrf_field(); ?>
        <div class="mdhpos-home-page">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <?php if (isset($component)) { $__componentOriginal0b10dd745b852ac1602248807228d6abd0d7baf8 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\PosMobile\FilterComponent::class, []); ?>
<?php $component->withName('pos-mobile.filter-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b10dd745b852ac1602248807228d6abd0d7baf8)): ?>
<?php $component = $__componentOriginal0b10dd745b852ac1602248807228d6abd0d7baf8; ?>
<?php unset($__componentOriginal0b10dd745b852ac1602248807228d6abd0d7baf8); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginale624d5d6b007a03c49b531d767b593f2dff7fcb0 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\PosMobile\BillingComponent::class, []); ?>
<?php $component->withName('pos-mobile.billing-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale624d5d6b007a03c49b531d767b593f2dff7fcb0)): ?>
<?php $component = $__componentOriginale624d5d6b007a03c49b531d767b593f2dff7fcb0; ?>
<?php unset($__componentOriginale624d5d6b007a03c49b531d767b593f2dff7fcb0); ?>
<?php endif; ?>
    </form>

    <div class="modal fade" id="receipt" tabindex="-1" role="dialog" aria-labelledby="paymodalLabel" aria-hidden="true">
        <div class="modal-dialog payment_modal">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel">Struk Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="feather-x float-right"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="mdhpos-filter">
                        <div class="filter">
                            <div class="filters-body" >
                                <div id="receiptbody"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0 border-0 p-3">
                    <div class="col-12 m-0 pr-0 pl-1">
                        <button type="button" class="btn btn-lg btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('assets/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script> 
    <script src="<?php echo e(asset('assets/vendors/slick/slick.min.js')); ?>"></script>  
    
    <script src="<?php echo e(asset('assets/vendors/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/toastr/evolution.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/sweetalert/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/sweetalert/evolution.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('js/connection.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/select3/dist/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/pos_mobile.js')); ?>"></script>

    <script src="<?php echo e(asset('js/mobile.js')); ?>" ></script> 
    
    

</body>

</html><?php /**PATH /var/www/pos/resources/views/layouts/pos_mobile.blade.php ENDPATH**/ ?>