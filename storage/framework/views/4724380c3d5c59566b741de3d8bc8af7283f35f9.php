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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Users")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('user.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.user')); ?></a>
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
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uUsers" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('user.name')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="<?php echo e($users->id); ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$users->name)); ?>" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.email')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="email" class="form-control" name="email" value="<?php echo e(old('email',$users->email)); ?>" id="email" required placeholder="<?php echo e(__('general.email')); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__("user.password")); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo e(__("user.password")); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('store.choose_timezone')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control choices" name="timezone">
                                                <?php $__currentLoopData = $timezone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value); ?>" <?php if($value==$users->timezone): ?> selected <?php endif; ?>><?php echo e($t); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('store.choose_store')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="store_id">
                                                <option value="0"><?php echo e(__('user.all_store')); ?></option>
                                                <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($s->id); ?>" <?php if($s->id == old('store_id',$users->store_id)): ?> selected <?php endif; ?>><?php echo e($s->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('user.choose_role')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="role_id">
                                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($d->id); ?>" <?php if($d->id == $users->role): ?> selected <?php endif; ?>><?php echo e($d->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.image')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="photo" name="photo" data-default-file="<?php echo e(asset(old('photo',$users->photo ?? ''))); ?>">
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
        </div>
        </section>

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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/usermanager/update_users.blade.php ENDPATH**/ ?>