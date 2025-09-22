<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($page); ?></title>
    <?php echo $__env->yieldContent('styles'); ?>
   <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.svg')); ?>" type="image/x-icon">
    <style type="text/css">
       
        @media    print{
           

        }
    </style>
    <script>window.print()</script>
</head>

<body>

    <div class="row" style="break-after:page" >
        <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-2 mb-2">
                <?php if(isset($option['product_name'])): ?> 
                <p class="bproductname" style="font-size: 8px;">
                    <b><?php echo e($p['name']); ?></b> 
                </p> 
                <?php endif; ?> 
                <img class="product_barcode" id="barcode_img" src="data:image/png;base64, <?php echo e(DNS1D::getBarcodePNG($p['barcode'], $p['type'])); ?>" height="30" width="110" style="margin-top: -16px">
                <div class="row">
                    <?php if(isset($option['barcode_number'])): ?>
                    <div class="col-6 bbarcode">
                        <div style="font-size: 8px;"><?php echo e($p['barcode']); ?> </div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($option['product_price'])): ?>
                    <div class="col-6 bprice">
                        <div style="font-size: 8px; "><?php echo e($p['price']); ?> </div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($option['store_name'])): ?>
                    <div class="col-12 btoko">
                        <div style="font-size: 10px; margin-top:-5px"><?php echo e($store->name); ?> </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <script src="<?php echo e(asset('assets/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>

</body>

</html>
<?php /**PATH /var/www/tymart/resources/views/admin/product/printb.blade.php ENDPATH**/ ?>