<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($page); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Netzen - POINT OF SALE" name="description">
    <meta content="PT. Netzen Media Akses" name="author">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/logo.png')); ?>"" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('theme/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="<?php echo e(asset('theme/css/icons.min.css')); ?>" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="<?php echo e(asset('theme/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/toastr/toastr.min.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>

</head>

<body data-sidebar="colored" data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <div id="loader"></div>
        <div id="sound"></div>
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

        
        <?php if (isset($component)) { $__componentOriginalcc265c08b8decbb8f7c643abf80abda4be028468 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\HeaderComponent::class, []); ?>
<?php $component->withName('admin.header-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc265c08b8decbb8f7c643abf80abda4be028468)): ?>
<?php $component = $__componentOriginalcc265c08b8decbb8f7c643abf80abda4be028468; ?>
<?php unset($__componentOriginalcc265c08b8decbb8f7c643abf80abda4be028468); ?>
<?php endif; ?>
        

        
        <?php if (isset($component)) { $__componentOriginal068db50c76a94ac9d3c3de8fa51f27e472def530 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\SidebarComponent::class, []); ?>
<?php $component->withName('admin.sidebar-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal068db50c76a94ac9d3c3de8fa51f27e472def530)): ?>
<?php $component = $__componentOriginal068db50c76a94ac9d3c3de8fa51f27e472def530; ?>
<?php unset($__componentOriginal068db50c76a94ac9d3c3de8fa51f27e472def530); ?>
<?php endif; ?>
        

        <div class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
            <!-- Footer Component Area -->
            <?php if (isset($component)) { $__componentOriginal9e6786ccfaee85663b003742946f942c953894e3 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\FooterComponent::class, []); ?>
<?php $component->withName('admin.footer-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9e6786ccfaee85663b003742946f942c953894e3)): ?>
<?php $component = $__componentOriginal9e6786ccfaee85663b003742946f942c953894e3; ?>
<?php unset($__componentOriginal9e6786ccfaee85663b003742946f942c953894e3); ?>
<?php endif; ?>
            <!-- End Footer Component -->


        </div>
    </div>

    <div class="rightbar-overlay"></div>

    <script src="<?php echo e(asset('assets/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/libs/metismenu/metisMenu.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('theme/libs/node-waves/waves.min.js')); ?>"></script>

    <script src="<?php echo e(asset('theme/js/app.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/vendors/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/toastr/evolution.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/sweetalert/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/sweetalert/evolution.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/numeral/numeral.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/lang.js')); ?>"></script>
    <script src="<?php echo e(asset('js/connection.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>

    <?php echo $__env->yieldContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\laragon\www\tymart\resources\views/layouts/admin.blade.php ENDPATH**/ ?>