
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal44deaddb0a6599429e827fa3b2b6ed2b0cffac38 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\PosMobile\HeaderComponent::class, []); ?>
<?php $component->withName('pos-mobile.header-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal44deaddb0a6599429e827fa3b2b6ed2b0cffac38)): ?>
<?php $component = $__componentOriginal44deaddb0a6599429e827fa3b2b6ed2b0cffac38; ?>
<?php unset($__componentOriginal44deaddb0a6599429e827fa3b2b6ed2b0cffac38); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<div class="osahan-main">
    <?php if (isset($component)) { $__componentOriginal35bec260e954e87c6bd48346b7923596f226f62b = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\PosMobile\CategoryComponent::class, []); ?>
<?php $component->withName('pos-mobile.category-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal35bec260e954e87c6bd48346b7923596f226f62b)): ?>
<?php $component = $__componentOriginal35bec260e954e87c6bd48346b7923596f226f62b; ?>
<?php unset($__componentOriginal35bec260e954e87c6bd48346b7923596f226f62b); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
    <div class="px-3 pt-4 pb-3 title d-flex align-items-center">
        <h6 class="m-0 font-weight-bold">Daftar Produk</h6> 
    </div> 
    <?php if (isset($component)) { $__componentOriginal5a1f2b38e8aef0ab3c42dc027bd2dc085d8f2cff = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\PosMobile\ProductComponent::class, []); ?>
<?php $component->withName('pos-mobile.product-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal5a1f2b38e8aef0ab3c42dc027bd2dc085d8f2cff)): ?>
<?php $component = $__componentOriginal5a1f2b38e8aef0ab3c42dc027bd2dc085d8f2cff; ?>
<?php unset($__componentOriginal5a1f2b38e8aef0ab3c42dc027bd2dc085d8f2cff); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
</div>

<div class="fixed-bottom p-3">
    <a href="javascript:void(0);" data-toggle="modal" data-target="#billingmodal" class=" btn btn-success btn-block btn-lg text-white rounded shadow text-decoration-none d-flex align-items-center shadow ">
        <div class="border-right pr-3">
            <h4 class="m-0">
                <i class="feather-shopping-bag" aria-hidden="true"></i>
            </h4>
        </div>
        <div class="ml-3 text-left"> 
            <input type="hidden" name="fixtotal" id="jumlahtotal" value="0">
            <p class="mb-0 font-weight-bold text-white" id="fixTotal">0</p>
        </div>
        <div class="ml-auto">
            <p class="mb-0 text-white"> Lihat Billing <i class="feather-chevron-right pl-2" aria-hidden="true"></i>
            </p>
        </div>
    </a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.pos_mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/pos/mobile.blade.php ENDPATH**/ ?>