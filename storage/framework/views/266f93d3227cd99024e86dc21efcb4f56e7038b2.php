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
                <div class="card ">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('generate.salary')); ?>" method="GET" class="row">
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label"><?php echo e(__('hrm.choose_department')); ?></label>
                                    <div class="input-group">
                                        <select class="form-control" id="department" name="department">
                                            <option value=""><?php echo e(__('hrm.choose_department')); ?></option>
                                            <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($d->id); ?>" <?php if($d->id == old('department')): ?> selected <?php endif; ?>><?php echo e($d->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label"><?php echo e(__('hrm.choose_designation')); ?></label>
                                    <div class="input-group">
                                        <select class="form-control" id="designation" name="designation_id">
                                            <option value=""><?php echo e(__('hrm.choose_designation')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label"><?php echo e(__('hrm.choose_employee')); ?></label>
                                    <div class="input-group">
                                        <select class="form-control" id="employee" name="employee" required>
                                            <option value=""><?php echo e(__('hrm.choose_employee')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 mb-3">
                                    <label class="control-label"> <?php echo e(__('general.date')); ?></label>
                                    <div class="input-group">
                                        <input type="date" name="date" id="date" class="form-control" required value="<?php echo e(old('end_date')); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <?php if(@$_GET['employee'] != null && @$_GET['date'] != null): ?>
                <form action="<?php echo e(route('salary.store')); ?>" method="POST" class="card ">
                    <div class="card-content">
                        <div class="card-body" id="printarea">
                            <div class="row mb-4">
                                <div class="col-4">
                                    <h1><?php echo e(__('hrm.salary_slip')); ?></h1>
                                </div>
                                <div class="col-6 text-end">
                                    <b class=""><?php echo e($store->name); ?></b>
                                    <address>
                                        <strong> <?php echo e($store->address); ?></strong>
                                        <br>
                                        <strong><?php echo e(__('general.phone')); ?> <?php echo e($store->phone); ?></strong>
                                        <br>
                                        <strong><?php echo e(__('general.email')); ?> <?php echo e($store->email); ?></strong>
                                    </address>
                                </div>
                                <div class="col-2 text-end">
                                    <img src="<?php echo e(asset($setting->logo)); ?>" style="width: 230px">
                                </div>
                            </div>
                            <hr style="border:2px solid black">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <b><?php echo e(__('hrm.to')); ?> :</b>
                                    <input type="hidden" name="user_id" value="<?php echo e($employee->user_id); ?>">
                                    <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>">
                                    <input type="hidden" name="total_work" value="<?php echo e($employee->month_work($year, $month)); ?>">
                                    <input type="hidden" name="attendance_this_month" value="<?php echo e($employee->month_total($year, $month)); ?>">
                                    <input type="hidden" name="designation" value="<?php echo e($employee->designation_id); ?>">
                                    <p><?php echo e($employee->user->name ?? ''); ?></p>
                                    <p style="margin-top: -15px"><?php echo e($employee->address); ?></p>
                                    <p style="margin-top: -15px"><?php echo e(__('general.phone')); ?> : <?php echo e($employee->phone); ?></p>
                                    <p style="margin-top: -15px"><?php echo e(__('general.email')); ?> : <?php echo e($employee->email); ?></p>
                                </div>

                                <div class="col-sm-8 text-end">

                                    <p><?php echo e(__('general.date')); ?>: <b><?php echo e(date('Y-m-d')); ?></b> </p>
                                    <p style="margin-top: -15px"><?php echo e(__('attendance.total_attendance_in_monthly')); ?> :
                                        <b><?php echo e($employee->month_total($year, $month)); ?>x</b>
                                    </p>
                                    <p style="margin-top: -15px"><?php echo e(__('attendance.total_work_in_monthly')); ?> :
                                        <b><?php echo e($employee->month_late($year, $month)); ?></b>
                                    </p>
                                    <p style="margin-top: -15px"><?php echo e(__('attendance.total_late_in_monthly')); ?> :
                                        <b><?php echo e($employee->month_work($year, $month)); ?></b>
                                    </p>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4><?php echo e(__('sidebar.deduction')); ?>:</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th><?php echo e(__('hrm.deduction_name')); ?></th>
                                                    <th><?php echo e(__('general.amount')); ?></th>
                                                    <th>X</th>
                                                    <th class="text-end"><?php echo e(__('general.total')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tc = 0;
                                                ?>
                                                <?php $__currentLoopData = $cutting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $total_cutting = 0;
                                                ?>
                                                <?php if($c->designation_id != null): ?>
                                                <?php if($c->designation_id == $employee->designation_id): ?>
                                                <?php if($c->priode == 'month'): ?>
                                                <?php
                                                $day = 1;
                                                ?>
                                                <?php else: ?>
                                                <?php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_cutting == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                ?>
                                                <?php endif; ?>
                                                <?php
                                                $total_cutting += $c->amount * $day;
                                                $tc += $c->amount * $day;
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo e($c->name); ?></td>
                                                    <td><?php echo e(number_format($c->amount)); ?></td>
                                                    <td>
                                                        <?php echo e($day); ?>

                                                    </td>
                                                    <td class="text-end">
                                                        <?php echo e(number_format($total_cutting)); ?>

                                                    </td>
                                                </tr>
                                                <?php else: ?>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <?php if($c->priode == 'month'): ?>
                                                <?php
                                                $day = 1;
                                                ?>
                                                <?php else: ?>
                                                <?php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_cutting == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                ?>
                                                <?php endif; ?>
                                                <?php
                                                $total_cutting += $c->amount * $day;
                                                $tc += $c->amount * $day;
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo e($c->name); ?></td>
                                                    <td><?php echo e(number_format($c->amount)); ?></td>
                                                    <td>
                                                        <?php if($c->priode == 'month'): ?>
                                                        1
                                                        <?php else: ?>
                                                        <?php
                                                        $calendar = CAL_GREGORIAN;
                                                        if ($setthrm->attendance_to_cutting == 'no') {
                                                        $day = cal_days_in_month($calendar, $month, $year);
                                                        } else {
                                                        $day = $employee->month_total($year, $month);
                                                        }

                                                        ?>
                                                        <?php echo e($day); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end"> <?php echo e(number_format($total_cutting)); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4><?php echo e(__('sidebar.e_allowance')); ?>:</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th><?php echo e(__('hrm.allowance_name')); ?></th>
                                                    <th><?php echo e(__('general.amount')); ?></th>
                                                    <th>X</th>
                                                    <th class="text-end"><?php echo e(__('general.total')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ta = 0;
                                                ?>
                                                <?php $__currentLoopData = $allowance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $total_allowance = 0;
                                                ?>
                                                <?php if($a->designation_id != null): ?>
                                                <?php if($a->designation_id == $employee->designation_id): ?>
                                                <?php if($a->priode == 'month'): ?>
                                                <?php
                                                $day = 1;
                                                ?>
                                                <?php else: ?>
                                                <?php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_salary == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                ?>
                                                <?php endif; ?>
                                                <?php
                                                $total_allowance += $a->amount * $day;
                                                $ta += $a->amount * $day;
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo e($a->name); ?></td>
                                                    <td><?php echo e(number_format($a->amount)); ?></td>
                                                    <td>
                                                        <?php echo e($day); ?>

                                                    </td>
                                                    <td class="text-end">
                                                        <?php echo e(number_format($total_allowance)); ?>

                                                    </td>
                                                </tr>
                                                <?php else: ?>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <?php if($a->priode == 'month'): ?>
                                                <?php
                                                $day = 1;
                                                ?>
                                                <?php else: ?>
                                                <?php
                                                $calendar = CAL_GREGORIAN;
                                                if ($setthrm->attendance_to_salary == 'no') {
                                                $day = cal_days_in_month($calendar, $month, $year);
                                                } else {
                                                $day = $employee->month_total($year, $month);
                                                }
                                                ?>
                                                <?php endif; ?>
                                                <?php
                                                $total_allowance += $a->amount * $day;
                                                $ta += $a->amount * $day;
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo e($a->name); ?></td>
                                                    <td><?php echo e(number_format($a->amount)); ?></td>
                                                    <td>
                                                        <?php if($a->priode == 'month'): ?>
                                                        1
                                                        <?php else: ?>
                                                        <?php
                                                        $calendar = CAL_GREGORIAN;
                                                        if ($setthrm->attendance_to_salary == 'no') {
                                                        $day = cal_days_in_month($calendar, $month, $year);
                                                        } else {
                                                        $day = $employee->month_total($year, $month);
                                                        }

                                                        ?>
                                                        <?php echo e($day); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end"> <?php echo e(number_format($total_allowance)); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4><?php echo e(__('hrm.salary_basic')); ?> :</h4>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white; " class="text-white">
                                                    <th>#</th>
                                                    <th></th>
                                                    <th><?php echo e(__('general.amount')); ?></th>
                                                    <th class="text-end"><?php echo e(__('general.total')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#</td>
                                                    <td><?php echo e(__('hrm.salary_basic')); ?></td>
                                                    <td><?php echo e(number_format($employee->salary)); ?></td>
                                                    <th class="text-end">
                                                        <input type="hidden" name="salary" value="<?php echo e($employee->salary); ?>"> <?php echo e(number_format($employee->salary)); ?>

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Bonus ( <?php echo e(__('general.optional')); ?> )</td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bonus" id="bonus" value="0">
                                                    </td>
                                                    <th class="text-end">
                                                        <p id="bonus_total"></p>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label class="control-label"><?php echo e(__('general.note')); ?> : </label>
                                    <textarea class="form-control" name="note" id="note"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">

                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                    <input type="hidden" name="cutting" value="<?php echo e($tc); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($setthrm->salary_tax); ?>">
                                    <input type="hidden" name="allowance" value="<?php echo e($ta); ?>">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <?php
                                                $subtotal = $ta + $employee->salary - $tc;
                                                ?>
                                                <tr>
                                                    <th><?php echo e(__('general.subtotal')); ?> : </th>
                                                    <td></td>
                                                    <td class="text-end" id="subtotal">
                                                        <?php echo e(number_format($subtotal)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $tax = ($setthrm->salary_tax / 100) * $subtotal;
                                                    $total = $subtotal - $tax;
                                                    ?>
                                                    <th><?php echo e(__('purchase.tax')); ?> :</th>
                                                    <td>
                                                        <b>(-)</b>
                                                    </td>
                                                    <td class="text-end"><?php echo e($setthrm->salary_tax); ?>% </td>
                                                </tr>
                                                <tr>
                                                    <th>Bonus :</th>
                                                    <td><b>(+)</b></td>
                                                    <td class="text-end" id="bonus_invoice">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('hrm.amount_total')); ?> :</th>
                                                    <td><b>(+)</b> <input type="hidden" id="total_salary" name="total" value="<?php echo e($total); ?>"></td>
                                                    <td class="text-end" id="salary_total"> <?php echo e(number_format($total)); ?> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo e(__('general.add')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        $("select[name='department']").change(function() {
            var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
            console.log(url);
            $("select[name='designation_id']").load(url);
            return false;
        });

        $("select[name='designation_id']").change(function() {
            var url = domainpath + "/pos-admin/salary/get-employee/" + $(this).val();
            console.log(url);
            $("select[name='employee']").load(url);
            return false;
        });

        $("#bonus").on("keyup", function() {
            var bonus = $("#bonus").val();
            $("#bonus").val(formatRupiah(bonus.toString()))
            $("#bonus_total").html(formatRupiah(bonus.toString()));
            $("#bonus_invoice").html(formatRupiah(bonus.toString()));

            var total = $("#total_salary").val();
            var total_salary = parseInt(total) + parseInt(bonus.replace(/[^0-9]/g, '').toString());
            $("#salary_total").html(formatRupiah(total_salary.toString()));
            $("#total_salary").val(total.toString());
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/salary/index.blade.php ENDPATH**/ ?>