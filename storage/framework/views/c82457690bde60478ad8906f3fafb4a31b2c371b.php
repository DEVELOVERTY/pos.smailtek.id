<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Pegawai")): ?>
                    <a href="<?php echo e(route('employee.index')); ?>" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> <?php echo e(__('sidebar.employee')); ?> </a>
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
        <div id="errors"></div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header header-warning">
                        <h5 class="card-title" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" class="row" id="uEmployee">
                                <?php echo csrf_field(); ?>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.choose_department')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-select" name="department" id="department">
                                            <h6><?php echo e(__('hrm.choose_department')); ?></h6>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($d->id); ?>" <?php if($d->id == old('department',$employee->designation->department->id ?? '')): ?> selected <?php endif; ?>><?php echo e($d->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.choose_designation')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-select" name="designation_id" id="designation_id">
                                            <option value="<?php echo e($employee->designation_id); ?>"><?php echo e($employee->designation->name ?? ''); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.choose_user')); ?></h6>
                                    <div class="form-group">
                                        <select class="form-select" name="user_id" id="user_id">
                                            <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($u->id); ?>" <?php if($u->id == old('user_id',$employee->user_id)): ?> selected <?php endif; ?>><?php echo e($u->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('general.phone')); ?></h6>
                                    <div class="form-group">
                                        <input type="number" name="phone" value="<?php echo e(old('phone',$employee->phone)); ?>" id="phone" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.hbd')); ?></h6>
                                    <div class="form-group">
                                        <input type="date" name="date_birth" value="<?php echo e(old('date_birth',$employee->date_birth)); ?>" id="date_birth" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <h6><?php echo e(__('hrm.salary_amount')); ?></h6>
                                    <div class="form-group">
                                        <input type="text" name="salary" value="<?php echo e(old('salary',number_format($employee->salary))); ?>" id="salary" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h6><?php echo e(__('general.address')); ?></h6>
                                    <div class="form-group">
                                        <textarea class="form-control" name="address" id="address"><?php echo e(old('address',$employee->address)); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <h6><?php echo e(__('hrm.about')); ?></h6>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                        <textarea class="form-control" name="about" id="about"><?php echo e(old('about',$employee->about)); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-info"><?php echo e(__('general.save')); ?></button>
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
<script>
    $(document).ready(function() {
        $("select[name='department']").change(function() {
            var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
            $("select[name='designation_id']").load(url);
            return false;
        });

        $("#amount").on("keyup", function() {
            var amount = $("#amount").val();
            $("#amount").val(formatRupiah(amount.toString()))
        });

        $("#salary").on("keyup", function() {
            var salary = $("#salary").val();
            $("#salary").val(formatRupiah(salary.toString()));
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/employee/update_employee.blade.php ENDPATH**/ ?>