<?php $__env->startSection('content'); ?> 
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/choices.js/choices.min.css')); ?>" />
<?php $__env->stopSection(); ?>
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
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e(__("sidebar.update_profile")); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uProfile" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.name')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',Auth()->user()->name)); ?>" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.timezone')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control choices" name="timezone">
                                                <?php $__currentLoopData = $timezone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value); ?>" <?php if($value==Auth()->user()->timezone): ?> selected <?php endif; ?>><?php echo e($t); ?> </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.email')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="email" class="form-control" name="email" value="<?php echo e(old('name',Auth()->user()->email)); ?>" id="email" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.image')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="photo" name="photo" data-default-file="">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1"><?php echo e(__('general.save')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e(__('sidebar.update_password')); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('change.password')); ?>" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('user.password')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="password" class="form-control" name="password" id="password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.confirm_password')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="password" class="form-control" name="confirm" id="password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-info me-1 mb-1"><?php echo e(__('general.save')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/choices.js/choices.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/profile.blade.php ENDPATH**/ ?>