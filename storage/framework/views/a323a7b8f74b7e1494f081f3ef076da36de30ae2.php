<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Adjustment")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('adjustment.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.list_adjs')); ?></a>
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
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-content">
                        <div class="card-body" id="printarea">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="pull-right"><b><?php echo e(__('general.date')); ?>:</b> <?php echo e(my_date($adjustment->created_at)); ?> </p>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-12 ">
                                    <?php echo e(__('general.store')); ?>:
                                    <address>
                                        <?php echo e($adjustment->store->name ?? ''); ?>,
                                        <br><?php echo e(__('general.phone')); ?> : <?php echo e($adjustment->store->phone ?? ''); ?>

                                        <br><?php echo e(__('general.address')); ?> : <?php echo e($adjustment->store->address ?? ''); ?>

                                    </address>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>#</th>
                                                    <th><?php echo e(__('produk.name')); ?></th>
                                                    <th><?php echo e(__('purchase.quantity')); ?></th>
                                                    <th><?php echo e(__('purchase.unit_cost')); ?> </th>
                                                    <th class="text-right"><?php echo e(__('general.subtotal')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $jumlah = 0;
                                                ?>
                                                <?php $__currentLoopData = $adjustment->adjustment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $subtotal = 0;
                                                $subtl = 0;
                                                $subtl += $gd->variation->purchase_price * $gd->qty_adjustment;
                                                $jumlah += $subtl;
                                                ?>
                                                <tr>
                                                    <td><?php echo e($no++); ?></td>
                                                    <td>
                                                        <?php echo e($gd->variation->product->name ?? ''); ?> <?php if($gd->variation->name != 'no-name'): ?> <?php echo e(' - '. $gd->variation->name ?? ''); ?> <?php endif; ?>
                                                    </td>
                                                    <td> <?php echo e($gd->qty_adjustment); ?> </td>
                                                    <td> <?php echo e(number_format($gd->variation->purchase_price)); ?> </td>
                                                    <td><?php echo e(number_format($subtl)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th><?php echo e(__('purchase.net_total')); ?> : </th>
                                                    <td></td>
                                                    <td><?php echo e(number_format($jumlah)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-xs-12">
                                        <img class="center-block" src="data:image/png;base64, <?php echo e(DNS1D::getBarcodePNG($adjustment->ref_no, 'C39')); ?>">
                                        <p><b><?php echo e($adjustment->ref_no); ?></b></p>
                                    </div>
                                </div>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Adjustment")): ?>
                                <div class="row text-center mt-5 mb-3">
                                    <div class="col-12">
                                        <a target="_blank" href="<?php echo e(route('adjustment.print',$adjustment->id)); ?>" class="btn btn-primary"><i class="fas fa-print"></i> <?php echo e(__('general.print')); ?></a>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/adjustment/detail.blade.php ENDPATH**/ ?>