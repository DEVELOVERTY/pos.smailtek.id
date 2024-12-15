<?php $__env->startSection('content'); ?>
<div class="authbg" style="background: url(<?=asset('installer/img/background.png');?>);background-size: cover;background-position: center;"></div>

<div class="wrapper-page auth-page-full">

    <div class="card shadow-none">
        <div class="card-block">

            <div class="auth-box">

                <div class="card-box shadow-none p-4">
                    <div class="p-2">
                        <div class="text-center mt-4">
                            <a href="<?php echo e(route('signin')); ?>"><img src="<?php echo e(asset($data->logo)); ?>" height="60px" alt="logo"></a>
                        </div>

                        <h4 class="font-size-18 mt-5 text-center"><?php echo e(__('signin')); ?></h4>
                        <p class="text-muted text-center"><?php echo e(__('auth.welcome')); ?></p>
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
                        <form class="mt-4" method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label" for="email"><?php echo e(__('auth.email')); ?></label>
                                <input type="email" class="form-control" id="email" value="<?php echo e(old('email')); ?>" name="email">
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="userpassword"><?php echo e(__('auth.password')); ?></label>
                                <input type="password" class="form-control" id="userpassword" name="password">
                            </div>

                            <div class="mb-3 row">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember"  <?php echo e(old('remember') ? 'checked' : ''); ?> class="form-check-input" id="customControlInline">
                                        <label class="form-check-label" for="customControlInline"> <?php echo e(__('auth.remember')); ?></label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><?php echo e(__('auth.signin')); ?></button>
                                </div>
                            </div>

                            <div class="mb-3 mt-2 mb-0 row">
                                <div class="col-12 mt-3">
                                    <a href="<?php echo e(route('password.request')); ?>"><i class="mdi mdi-lock"></i> <?php echo e(__('auth.forget')); ?></a>
                                </div>
                            </div>

                        </form>

                         

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\pos\resources\views/auth/login.blade.php ENDPATH**/ ?>