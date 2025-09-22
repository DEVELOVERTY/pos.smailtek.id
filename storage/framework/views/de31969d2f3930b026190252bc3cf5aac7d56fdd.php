<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pengeluaran")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('expense.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.expense')); ?></a>
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
                            <div class="row invoice-info">

                                <div class="col-sm-6 invoice-col">
                                    <?php echo e(__('general.store')); ?> :
                                    <address>
                                        <strong><?php echo e($data->store->name); ?>,</strong>
                                        <br> <?php echo e($data->store->address); ?>

                                    </address>
                                </div>

                                <div class="col-sm-6 invoice-col">
                                    <b><?php echo e(__('general.ref_no')); ?> :</b> #<?php echo e($data->ref_no); ?><br>
                                    <b><?php echo e(__('general.date')); ?> :</b> <?php echo e(my_date($data->created_at)); ?><br>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th><?php echo e(__('general.ref_no')); ?></th>
                                                    <th><?php echo e(__('general.category_name')); ?></th>
                                                    <th><?php echo e(__('expense.name')); ?></th>
                                                    <th><?php echo e(__('expense.amount')); ?></th>
                                                    <th><?php echo e(__('general.store')); ?></th>
                                                    <th><?php echo e(__('general.date')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <?php echo e($data->ref_no); ?> </td>
                                                    <td> <?php echo e($data->category->name ?? ''); ?> </td>
                                                    <td> <?php echo e($data->name); ?> </td>
                                                    <td> <?php echo e(number_format($data->amount)); ?> </td>
                                                    <td> <?php echo e($data->store->name ?? ''); ?> </td>
                                                    <td> <?php echo e($data->created_at); ?> </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <strong><?php echo e(__('general.detail')); ?> / <?php echo e(__("general.note")); ?> :</strong><br>
                                    <?= $data->detail; ?>


                                </div>
                            </div>
                            <?php if($data->document != null): ?>
                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <a target="_blank" href="<?php echo e(asset($data->document)); ?>" class="btn btn-primary"><i class="fas fa-print"></i> Download <?php echo e(__('general.file')); ?></a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/expense/detail.blade.php ENDPATH**/ ?>