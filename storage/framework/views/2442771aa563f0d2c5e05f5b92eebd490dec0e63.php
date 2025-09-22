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
                                    <form action="<?php echo e(route('attendance.today_report')); ?>" method="GET" class="row">
                                        <div class="col-sm-6 col-md-6 mb-3">
                                            <label class="control-label"><?php echo e(__('hrm.choose_designation')); ?> </label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="designation" name="designation">
                                                    <option value=""><?php echo e(__('hrm.choose_designation')); ?> </option>
                                                    <?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($s->id); ?>" <?php if(isset($_GET['designation'])): ?> <?php if($s->id==$_GET['designation']): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($s->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3">
                                            <label class="control-label"><?php echo e(__('general.date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="date" id="date" placeholder="Tanggal" class="form-control" value="<?php echo e(old('date')); ?>">
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
                                            <th><?php echo e(__('attendance.status')); ?></th>
                                            <th><?php echo e(__('general.store')); ?></th>
                                            <th><?php echo e(__('attendance.entry')); ?></th>
                                            <th><?php echo e(__('attendance.out')); ?></th>
                                            <th><?php echo e(__('attendance.late')); ?></th>
                                            <th><?php echo e(__('attendance.total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>#</td>
                                            <td><?php echo e($c->user->name); ?></td>
                                            <td>
                                                <?php if($c->today_attendance($date) == 'yes'): ?>
                                                <span class="badge bg-primary"><i class="fas fa-check-circle"></i></span>
                                                <?php else: ?>
                                                <span class="badge bg-danger"><i class="fas fa-times"></i></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($c->user->store->name); ?></td>
                                            <td><?php echo e($c->today_checkint($date)); ?></td>
                                            <td><?php echo e($c->today_checkout($date)); ?></td>
                                            <td><?php echo e($c->today_late($date)); ?></td>
                                            <td><?php echo e($c->today_work($date)); ?></td>
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
        </section>

    </div>

    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/reports/attendance/today.blade.php ENDPATH**/ ?>