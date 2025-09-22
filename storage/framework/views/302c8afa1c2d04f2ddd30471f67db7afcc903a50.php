<?php $__env->startSection('content'); ?> 
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
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data"  class="form form-vertical"  id="uHrm">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.time_min')); ?></label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="min_check_int" value="<?php echo e(old('min_check_int',$hrm->min_check_int ?? '')); ?>" required id="min_check_int"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.time_max')); ?></label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="max_check_int" value="<?php echo e(old('max_check_int',$hrm->max_check_int ?? '')); ?>" required id="max_check_int"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.time_out')); ?></label>
                                                <div class="position-relative">
                                                    <input type="time" class="form-control" name="min_check_out" value="<?php echo e(old('min_check_out',$hrm->min_check_out ?? '')); ?>" required id="min_check_out"> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.late_loss')); ?></label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_in_late">
                                                        <?php if($hrm->attendance_in_late == 'yes'): ?>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                        <?php else: ?> 
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                        <?php endif; ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.allowance_to_attendance')); ?></label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_to_salary">
                                                        <?php if($hrm->attendance_to_salary == 'yes'): ?>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                        <?php else: ?> 
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                        <?php endif; ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.deduction_to_attendance')); ?></label>
                                                <div class="position-relative">
                                                    <select class="form-control" name="attendance_to_cutting">
                                                        <?php if($hrm->attendance_to_cutting == 'yes'): ?>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                        <?php else: ?> 
                                                            <option value="no"><?php echo e(__('settings.no')); ?></option>
                                                            <option value="yes"><?php echo e(__('settings.connect')); ?></option>
                                                        <?php endif; ?>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-4 mt-3">
                                            <div class="form-group has-icon-left">
                                                <label for="system_name"><?php echo e(__('settings.salary_tax')); ?> ( % )</label>
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" name="salary_tax" value="<?php echo e(old('salary_tax',$hrm->salary_tax ?? '')); ?>" required id="salary_tax"> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4 d-flex justify-content-end mt-4">
                                            <button  class="btn btn-info me-1 mb-1"><?php echo e(__('save')); ?></button> 
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
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/settings/hrm.blade.php ENDPATH**/ ?>