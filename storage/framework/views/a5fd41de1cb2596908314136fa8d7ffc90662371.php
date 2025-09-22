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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Tunjangan")): ?>
                    <a href="<?php echo e(route('allowance.index')); ?>" class="btn btn-md btn-primary float-end"><i class="fa fa-list"></i> <?php echo e(__('sidebar.e_allowance')); ?> </a>
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
                        <h5 class="card-title" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uAllowance" method="POST" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('hrm.allowance_name')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$allowance->name)); ?>" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('hrm.choose_department')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="department">
                                                <?php if($allowance->designation_id != 0): ?>
                                                <option value="<?php echo e($allowance->designation->department_id); ?>"><?php echo e($allowance->designation->department->name); ?></option>
                                                <?php else: ?>
                                                <option value=""><?php echo e(__('hrm.all_employee')); ?></option>
                                                <?php endif; ?>
                                                <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('hrm.choose_designation')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="<?php echo e($allowance->id); ?>">
                                            <select class="form-control" name="designation_id">
                                                <option value="<?php echo e($allowance->designation_id); ?>"><?php echo e($allowance->designation->name ?? __('hrm.all_employee')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('hrm.choose_circle')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="priode">
                                                <?php $__currentLoopData = $priode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($p); ?>" <?php if($p==old('priode',$allowance->priode)): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('hrm.amount_allowance')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="amount" value="<?php echo e(old('amount',number_format($allowance->amount))); ?>" id="amount" required>
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
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
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
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/allowance/update.blade.php ENDPATH**/ ?>