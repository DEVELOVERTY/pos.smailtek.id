

<?php $__env->startSection('content'); ?>
<div id="layout-wrapper">
    <div class="p-4">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-12 text-center">
                            <h2><?php echo e($page); ?></h2>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center ">
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="card  store-box">
                            <div class="card-body p-4">
                                <div class="d-flex mt-2">
                                    <div class="flex-shrink-0 align-self-center">
                                        <i class="mdi mdi-store h2"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-auto text-end">
                                        <h4><?php echo e($d->name); ?></h4>
                                        <p class="text-muted mb-0"><?php echo e($d->address); ?></p>
                                    </div>
                                </div>
                                <div class="pricing-features mt-5 pt-2">
                                    <p><span class="badge bg-info"> <i class="mdi mdi-card-account-phone me-2" style="font-size: 14px;"></i></span> <?php echo e($d->phone); ?></p>
                                    <p><span class="badge bg-info"> <i class="mdi mdi-email me-2" style="font-size: 14px;"></i></span> <?php echo e($d->email); ?></p>
                                </div>
                                <div class="d-grid mt-5">
                                    <a href="<?php echo e(route('choose.store',$d->id)); ?>" class="btn btn-primary waves-effect waves-light"><?php echo e(__('sidebar.choose_store')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div> 
    </div> 
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/auth/choose_store.blade.php ENDPATH**/ ?>