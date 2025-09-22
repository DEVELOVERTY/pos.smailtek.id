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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Department")): ?>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i> <?php echo e(__('hrm.add_department')); ?> </a>
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
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                        <a href="javascript:void(0)" class="d-none" id="update_d" data-bs-toggle="modal" data-bs-target="#update_department"></a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center"> # </th>
                                            <th><?php echo e(__('hrm.department_name')); ?></th>
                                            <th><?php echo e(__('hrm.total_designation')); ?></th>
                                            <th><?php echo e(__('general.action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="edit_department">
                                            <td><?php echo e($no++); ?>

                                                <p id="di" class="d-none"><?php echo e($d->id); ?></p>
                                            </td>
                                            <td>
                                                <p id="dn"><?php echo e($d->name); ?></p>
                                            </td>
                                            <td><?php echo e(count($d->designation)); ?></td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Department")): ?>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-warning department"><?php echo e(__('hrm.update_department')); ?></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Hapus Department")): ?>
                                                <a href="<?php echo e(route('department.delete',$d->id)); ?>" class="btn btn-sm btn-danger deletebutton"><?php echo e(__('hrm.delete_department')); ?></a>
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
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Department")): ?>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('department.store','create')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header header-modal">
                <h5 class="modal-title text-white" id="add"><?php echo e(__('hrm.add_department')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name"><?php echo e(__('hrm.department_name')); ?></label>
                    <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required id="name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.add')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Department")): ?>
<div class="modal fade" id="update_department" tabindex="-1" role="dialog" aria-labelledby="update_department" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('department.store','up')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header header-warning">
                <h5 class="modal-title" id=""><?php echo e(__('hrm.update_department')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name"><?php echo e(__('hrm.department_name')); ?></label>
                    <input type="hidden" name="id" id="department_id" value="">
                    <input type="text" class="form-control" id="department_name" name="name" value="<?php echo e(old('name')); ?>" required>
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
<script src="<?php echo e(asset('js/department.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/hrm/department.blade.php ENDPATH**/ ?>