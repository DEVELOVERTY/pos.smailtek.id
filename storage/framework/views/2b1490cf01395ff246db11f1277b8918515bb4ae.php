<?php $__env->startSection('content'); ?>
        <div class="row pos-content">
           <?php if (isset($component)) { $__componentOriginalf60ed835728d1e1e73dfe977fc12d85eddac49dc = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pos\ProductComponent::class, []); ?>
<?php $component->withName('pos.product-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf60ed835728d1e1e73dfe977fc12d85eddac49dc)): ?>
<?php $component = $__componentOriginalf60ed835728d1e1e73dfe977fc12d85eddac49dc; ?>
<?php unset($__componentOriginalf60ed835728d1e1e73dfe977fc12d85eddac49dc); ?>
<?php endif; ?>
           <?php if (isset($component)) { $__componentOriginal8ade5964474842c78d822882ec710762f7c1ed2a = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Pos\BillComponent::class, []); ?>
<?php $component->withName('pos.bill-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ade5964474842c78d822882ec710762f7c1ed2a)): ?>
<?php $component = $__componentOriginal8ade5964474842c78d822882ec710762f7c1ed2a; ?>
<?php unset($__componentOriginal8ade5964474842c78d822882ec710762f7c1ed2a); ?>
<?php endif; ?>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/pos/index.blade.php ENDPATH**/ ?>