<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/datatables.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')); ?>">
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
                            <form action="<?php echo e(route('salary.list')); ?>" method="GET" class="row">
                                <div class="col-sm-12 col-md-4 mb-3">
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
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="control-label"><?php echo e(__('hrm.choose_designation')); ?></label>
                                    <div class="input-group">
                                        <select class="form-control" id="designation" name="designation_id">
                                            <option value=""><?php echo e(__('hrm.choose_designation')); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
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
                <?php if(@$_GET['designation_id'] != null && @$_GET['date'] != null): ?>
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
                                                <th><?php echo e(__('hrm.employee_name')); ?></th>
                                                <th><?php echo e(__('hrm.salary_generate_date')); ?></th>
                                                <th><?php echo e(__('sidebar.deduction')); ?></th>
                                                <th><?php echo e(__('sidebar.e_allowance')); ?></th>
                                                <th>Bonus</th>
                                                <th><?php echo e(__('purchase.tax')); ?></th>
                                                <th><?php echo e(__('hrm.salary_basic')); ?></th>
                                                <th><?php echo e(__('general.total')); ?></th>
                                                <th><?php echo e(__('general.payment_status')); ?></th>
                                                <th><?php echo e(__('general.action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="data-product">
                                                    <td><?php echo e($c->user->name); ?></td>
                                                    <td><?php echo e($c->created_at); ?></td>
                                                    <td><?php echo e(number_format($c->cutting)); ?></td>
                                                    <td><?php echo e(number_format($c->allowance)); ?></td>
                                                    <td><?php echo e(number_format($c->bonus ?? 0)); ?></td>
                                                    <td><?php echo e($c->tax); ?>%</td>
                                                    <td><?php echo e(number_format($c->salary)); ?></td>
                                                   
                                                    <td><?php echo e(number_format($c->total)); ?></td>
                                                    <td>
                                                        <?php if($c->status == 'due'): ?>
                                                            <?php echo e(__('hrm.before_pay')); ?>

                                                        <?php else: ?>
                                                            <?php echo e(__('hrm.after_pay')); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($c->status == 'due'): ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Pengajian")): ?>
                                                            <a href="javascript:void(0)" id="<?php echo e($c->id); ?>" onclick="getstatusmodal(this.id)" class="btn btn-sm btn-info"><i class="fa fa-money-bill"></i></a>
                                                        <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Slip Gaji")): ?>
                                                            <a href="<?php echo e(route('salary.detail', $c->id)); ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('salary.status')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header header-modal">
                <h5 class="modal-title text-white" id=""><?php echo e(__('purchase.change_payment_status')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="system_name"><?php echo e(__('purchase.status')); ?></label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="paid"><?php echo e(__('hrm.after_pay')); ?></option> 
                    </select>
                </div>

                <div class="form-group">
                    <label for="system_name"><?php echo e(__('general.payment_method')); ?></label> 
                    <select class="form-control" name="method">
                        <option value="Bank Transfer">Bank Transfer</option> 
                        <option value="Cash">Cash</option> 
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo e(__('general.add_payment')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/datatables/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/datatables/datatables.js')); ?>"></script>
    <script>
        function getstatusmodal(id)
        {
            $("#ti").val(id);
            document.getElementById("update_status").click();
        }

        $(document).ready(function() {
            $("select[name='department']").change(function() {
                var url = domainpath + "/pos-admin/hrm/get-designation/" + $(this).val();
                console.log(url);
                $("select[name='designation_id']").load(url);
                return false;
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/salary/list.blade.php ENDPATH**/ ?>