 
<?php $__env->startSection('content'); ?> 
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Designation")): ?>
                    <a href="<?php echo e(route('designation.index')); ?>" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> <?php echo e(__('sidebar.designation')); ?> </a>
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
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="cDesignation" method="POST" class="row">
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.department_name')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-select" name="department_id" id="department">
                                            <option value=""><?php echo e(__('hrm.choose_department')); ?></option>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($d->id); ?>" <?php if($d->id == old('department_id')): ?> selected <?php endif; ?>><?php echo e($d->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.designation_name')); ?></h6>
                                    <div class="form-group">
                                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button  class="btn btn-primary me-1 mb-1"><?php echo e(__('general.add')); ?></button>
                                    <a href="<?php echo e(route('designation.index')); ?>" class="btn btn-light-secondary me-1 mb-1"><?php echo e(__('general.back')); ?></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/hrm/add_designation.blade.php ENDPATH**/ ?>