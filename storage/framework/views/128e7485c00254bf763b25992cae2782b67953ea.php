<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($page); ?></title>
 
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/pos.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/logo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/fontawesome/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/toastr/toastr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/select3/dist/css/select2.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/slick/slick.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/slick/slick-theme.min.css')); ?>" />
   
</head>

<body>
    <div id="app" class="hide-print">
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
        
        
        <?php if (isset($component)) { $__componentOriginala55ad8d3deb4c0c17cfca98ccf5c2645816bc2ed = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pos\SidebarComponent::class, []); ?>
<?php $component->withName('pos.sidebar-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala55ad8d3deb4c0c17cfca98ccf5c2645816bc2ed)): ?>
<?php $component = $__componentOriginala55ad8d3deb4c0c17cfca98ccf5c2645816bc2ed; ?>
<?php unset($__componentOriginala55ad8d3deb4c0c17cfca98ccf5c2645816bc2ed); ?>
<?php endif; ?>
        

        <form method="POST" id="main" class='layout-navbar cTransaction'>
            <?php echo csrf_field(); ?>
            
            <?php if (isset($component)) { $__componentOriginal90c2535f6da8d7b6ee66e232c0e1a531925893e4 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pos\TopHeaderComponent::class, []); ?>
<?php $component->withName('pos.top-header-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal90c2535f6da8d7b6ee66e232c0e1a531925893e4)): ?>
<?php $component = $__componentOriginal90c2535f6da8d7b6ee66e232c0e1a531925893e4; ?>
<?php unset($__componentOriginal90c2535f6da8d7b6ee66e232c0e1a531925893e4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal7fb6e116ade22170d51ff614ed91129edb1ce040 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pos\HeaderComponent::class, []); ?>
<?php $component->withName('pos.header-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fb6e116ade22170d51ff614ed91129edb1ce040)): ?>
<?php $component = $__componentOriginal7fb6e116ade22170d51ff614ed91129edb1ce040; ?>
<?php unset($__componentOriginal7fb6e116ade22170d51ff614ed91129edb1ce040); ?>
<?php endif; ?>
            

            <div id="main-content">

                <?php echo $__env->yieldContent('content'); ?>

                
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.pos.footer-component','data' => []]); ?>
<?php $component->withName('pos.footer-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                

            </div>
        </form>
    </div>

    <div class="modal fade text-left" id="receipt" tabindex="-1" role="dialog" aria-labelledby="receipt"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="height: 90vh; width:50vh">
                <div class="modal-header">
                    <h4 class="modal-title" id="receipts">Receipt Struck</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times text-white"></i>
                    </button>
                </div>
                <div class="modal-body print-area" id="receiptbody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-block btn-primary buttonprint" onclick="printcepeipt(this.id)">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><?php echo e(__('pos.print')); ?></span>
                    </button>
                    <button type="button" class="btn btn-block btn-primary pageprint" onclick="printpage(this.id)">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Print Struk Page</span>
                    </button>
                    <button type="button" id="closeprint" class="btn btn-block btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('assets/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/fontawesome/all.min.js')); ?>"></script>
 
    <script src="<?php echo e(asset('assets/vendors/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/toastr/evolution.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/slick/slick.min.js')); ?>"></script>  
    <script src="<?php echo e(asset('assets/vendors/sweetalert/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/sweetalert/evolution.js')); ?>"></script>  
    <script src="<?php echo e(asset('assets/vendors/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/scanner/scanner.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/select3/dist/js/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('js/connection.js')); ?>"></script>
    <script src="<?php echo e(asset('js/pos.js')); ?>"></script>
    <script src="<?php echo e(asset('js/mobile.js')); ?>"></script> 
</body>

</html>
<?php /**PATH /var/www/tymart/resources/views/layouts/pos.blade.php ENDPATH**/ ?>