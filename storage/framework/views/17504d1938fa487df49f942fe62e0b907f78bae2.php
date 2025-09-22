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
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="accordion" id="accordionSearching">
                        <div class="accordion-item border rounded mt-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#searchdata" aria-expanded="false" aria-controls="searchdata">
                                    <i class="fa fa-search" style="margin-right: 5px;"></i> <?php echo e(__('general.search')); ?>

                                </button>
                            </h2>
                            <div id="searchdata" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSearching">
                                <div class="accordion-body">
                                    <form action="<?php echo e(route('attendance.total')); ?>" method="GET" class="row">
                                        <div class="col-sm-6 col-md-4 mb-3">
                                            <label class="control-label"><?php echo e(__('hrm.choose_designation')); ?></label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="designation" name="designation">
                                                    <option value=""><?php echo e(__('hrm.choose_designation')); ?></option>
                                                    <?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($s->id); ?>" <?php if(isset($_GET['designation'])): ?> <?php if($s->id==$_GET['designation']): ?> selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($s->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label"><?php echo e(__('general.start_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="start" id="start" class="form-control" value="<?php echo e(old('start')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label"><?php echo e(__('general.end_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="end" id="end" class="form-control" value="<?php echo e(old('end')); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
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
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('hrm.employee_name')); ?></th>
                                            <th><?php echo e(__('report.attendance_total')); ?></th>
                                            <th><?php echo e(__('report.late_total')); ?></th>
                                            <th><?php echo e(__('report.work_total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>#</td>
                                            <td><?php echo e($c->user->name); ?></td>
                                            <td><?php echo e($c->total_attendance($start,$end)); ?></td>
                                            <td><?php echo e($c->total_late($start,$end)); ?></td>
                                            <td><?php echo e($c->total_work($start,$end)); ?></td>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/reports/attendance/total.blade.php ENDPATH**/ ?>