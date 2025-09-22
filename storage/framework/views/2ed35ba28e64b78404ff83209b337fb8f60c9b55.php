
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
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
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card header-border">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" class="form form-vertical" id="uSetting">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.system_name')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$settings->name ?? '')); ?>" required id="system_name"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="email-id-icon"><?php echo e(__('settings.d_mail')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="default_email" value="<?php echo e(old('default_email',$settings->default_email ?? '')); ?>" id="email-id-icon"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="mobile-id-icon"><?php echo e(__('settings.d_phone')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="default_phone" value="<?php echo e(old('default_phone',$settings->default_phone ?? '')); ?>" id="mobile-id-icon"> 
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="smtp_host"><?php echo e(__('settings.smtp_host')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="smtp_host" value="<?php echo e(old('smtp_host',$settings->smtp_host ?? '')); ?>" id="smptp_host"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-6 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="port"><?php echo e(__('settings.smtp_port')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="port" value="<?php echo e(old('port',$settings->port ?? '')); ?>" id="port"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="username"><?php echo e(__('settings.smtp_username')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="username" value="<?php echo e(old('username',$settings->username ?? '')); ?>" id="username"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="password"><?php echo e(__('settings.smtp_password')); ?></label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="password" id="password"> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="encrypt"><?php echo e(__('settings.smtp_encrypt')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="encrypt" value="<?php echo e(old('encrypt',$settings->encrypt ?? '')); ?>" id="encrypt"> 
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_host"><?php echo e(__('settings.ftp_host')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="host" value="<?php echo e(old('host',$settings->host ?? '')); ?>" id="ftp_host"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_user"><?php echo e(__('settings.ftp_username')); ?></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="user" value="<?php echo e(old('user',$settings->user ?? '')); ?>" id="ftp_user"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="ftp_password"><?php echo e(__('settings.ftp_password')); ?></label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="pass" id="ftp_password"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group has-icon-left">
                                                <label for="rest_api">Masukkan Rest Api</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="rest_api" value="<?php echo e($settings->rest_api); ?>" id="restapi">
                                                    <button class="btn btn-info" type="button" id="getrest"><i class="fas fa-random"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="divider">
                                            <div class="divider-text mb-3 mt-3"><?php echo e(__('settings.system_logo')); ?></div>
                                        </div>

                                        <div class="col-12 mb-5">
                                            <input class="dropify" type="file" id="logo" name="logo" data-default-file="<?php echo e(asset(old('logo',$settings->logo ?? ''))); ?>">
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt04">
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
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>