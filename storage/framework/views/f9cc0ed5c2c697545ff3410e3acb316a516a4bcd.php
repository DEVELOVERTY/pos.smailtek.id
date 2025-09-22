<!doctype html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <title><?php echo e($page ?? 'MDHPOS'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="MDHPOS - COMPLETE POINT OF SALE" name="description">
    <meta content="Mdh Digital" name="author">
    <link rel="shortcut icon" href="<?php echo e(asset('theme/images/icon.png')); ?>" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('theme/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="<?php echo e(asset('theme/css/icons.min.css')); ?>" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="<?php echo e(asset('theme/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css">

</head>

<body class="auth-pages" style="background-color: #fff;"> 

        <?php if (isset($component)) { $__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\LangComponent::class, []); ?>
<?php $component->withName('admin.lang-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d)): ?>
<?php $component = $__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d; ?>
<?php unset($__componentOriginal0b927b0b84cd6172942fbba1bd76fe87015af10d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
        
    </body>

</html><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/layouts/app.blade.php ENDPATH**/ ?>