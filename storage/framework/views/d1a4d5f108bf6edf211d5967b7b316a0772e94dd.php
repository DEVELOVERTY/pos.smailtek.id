
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Mata Uang")): ?>
                    <a class="btn btn-md btn-primary float-end" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add"><i class="fa fa-plus"></i> <?php echo e(__('settings.add_currency')); ?></a>
                    <?php endif; ?>
                    <a href="javascript:void(0)" class="d-none" id="update_c" data-bs-toggle="modal" data-bs-target="#update_currency"></a>
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\ValidationComponent::class, []); ?>
<?php $component->withName('admin.validation-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card header-border">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> No </th>
                                            <th><?php echo e(__('settings.simbol')); ?></th>
                                            <th><?php echo e(__('sidebar.country')); ?></th>
                                            <th><?php echo e(__('sidebar.currency')); ?></th>
                                            <th><?php echo e(__('general.code')); ?></th>
                                            <th><?php echo e(__('general.store')); ?></th>
                                            <th><?php echo e(__('general.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="edit_currency">
                                            <td><?php echo e($no++); ?> </td>
                                            <td>
                                                <p id="ci" class="d-none"><?php echo e($d->id); ?></p>
                                                <p id="cd"><?php echo e($d->code); ?></p>
                                            </td>
                                            <td>
                                                <p id="cn"><?php echo e($d->country); ?></p>
                                            </td>
                                            <td>
                                                <p id="cr"><?php echo e($d->currency); ?></p>
                                            </td>
                                            <td>
                                                <p id="cdd"><?php echo e($d->code); ?></p>
                                            </td>
                                            <td><?php echo e(count($d->store)); ?></td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Mata Uang")): ?>
                                                <a href="javascript:void(0)" class="btn btn-warning currency"><i class="fas fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Hapus Mata Uang")): ?>
                                                <a href="<?php echo e(route('currency.delete',$d->id)); ?>" class="btn btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
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
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Mata Uang")): ?>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('currency.store','create')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="add"><?php echo e(__('settings.add_currency')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('sidebar.country')); ?></label>
                    <input type="text" class="form-control" name="country" value="<?php echo e(old('country')); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('sidebar.currency')); ?></label>
                    <input type="text" class="form-control" name="currency" value="<?php echo e(old('currency')); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('settings.simbol')); ?></label>
                    <input type="text" class="form-control" name="symbol" value="<?php echo e(old('symbol')); ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('general.code')); ?></label>
                    <input type="text" class="form-control" name="code" value="<?php echo e(old('code')); ?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('settings.add_currency')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Mata Uang")): ?>
<div class="modal fade" id="update_currency" tabindex="-1" role="dialog" aria-labelledby="update_currency" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('currency.store','up')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id=""><?php echo e(__('settings.update_currency')); ?> </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="system_name"><?php echo e(__('sidebar.country')); ?></label>
                    <input type="hidden" name="id" id="currency_id" value="">
                    <input type="text" class="form-control" id="currency_name" name="country" value="" required>
                </div>
                <div class="form-group mb-3">
                    <label for="system_name"><?php echo e(__('settings.simbol')); ?></label>
                    <input type="text" class="form-control" id="currency_code" name="symbol" value="" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('sidebar.currency')); ?></label>
                    <input type="text" class="form-control" id="currency_c" name="currency" required>
                </div>
                <div class="form-group mb-3">
                    <label for="time"><?php echo e(__('general.code')); ?></label>
                    <input type="text" class="form-control" id="currency_cd" name="code" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.save')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/settings/currency.blade.php ENDPATH**/ ?>