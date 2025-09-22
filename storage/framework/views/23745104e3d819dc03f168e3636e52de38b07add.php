<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
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
        <div class="row">
            <?php if($variation != ''): ?>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e(__('report.product_popular')); ?></h5>
                    </div>
                    <div class="card-content">
                        <img src="<?php echo e(asset($variation->gambar->path ?? 'uploads/image.jpg')); ?>" class="card-img-top img-fluid" alt="singleminded">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($variation->product->name ?? ''); ?> <?php if($variation->name != 'no-name'): ?> <?php echo e($variation->name); ?> <?php endif; ?>
                            </h5>
                            <p class="card-text">
                                <?= $variation->product->description ?>
                            </p>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item"><b><?php echo e($data->quantity); ?></b> Terjual</li>
                        <li class="list-group-item"><?php echo e(__('purchase.unit_cost')); ?><b>: <?php echo e(my_currency($variation->selling_price)); ?></b></li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-xl-8 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e(__('report.ten_popular')); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('produk.name')); ?></th>
                                            <th><?php echo e(__('report.sell')); ?></th>
                                            <th><?php echo e(__('purchase.unit_cost')); ?></th>
                                            <th><?php echo e(__('general.image')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($p['name']); ?></td>
                                            <td><?php echo e($p['selling']); ?></td>
                                            <td><?php echo e(number_format($p['unit_price'])); ?></td>
                                            <td> <img src="<?php echo e(asset($p['image'])); ?>" style="width: 50px; border-radius: 10%"> </td>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/reports/stock/top_product.blade.php ENDPATH**/ ?>