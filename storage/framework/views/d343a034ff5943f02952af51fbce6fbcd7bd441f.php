
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Stock Transfer")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('transfer.create')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.add_stock_transfer')); ?></a>
                    <?php endif; ?>
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
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 mb-3">
                                            <label class="control-label"><?php echo e(__('general.start_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3">
                                            <label class="control-label"><?php echo e(__('general.end_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-content">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="card header-border">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="transferContent">
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('general.action')); ?></th>
                                            <th><?php echo e(__('general.date')); ?></th>
                                            <th><?php echo e(__('general.ref_no')); ?></th>
                                            <th><?php echo e(__('transfer.from')); ?></th>
                                            <th><?php echo e(__('transfer.to')); ?></th>
                                            <th><?php echo e(__('transfer.status')); ?></th>
                                            <th><?php echo e(__('purchase.shipping_cost')); ?></th>
                                            <th><?php echo e(__('general.total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-error-circle me-50"></i> <?php echo e(__('general.action')); ?>

                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Stock Transfer")): ?>
                                                            <a class="dropdown-item" href="<?php echo e(route('transfer.detail', $d->id)); ?>">
                                                                <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Stock Transfer")): ?>
                                                            <?php if($d->status != 'complete'): ?>
                                                            <a class="dropdown-item po-edit" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getstatusmodal(this.id)">
                                                                <i class="fas fa-check-circle"></i> <?php echo e(__('general.change_status')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Stock Transfer")): ?>
                                                            <a target="_blank" class="dropdown-item" href="<?php echo e(route('transfer.print', $d->id)); ?>">
                                                                <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <a class="dropdown-item" href="javascript:void(0)"> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                                            <td> <?php echo e($d->ref_no); ?> </td>
                                            <td> <?php echo e($d->transfer->fromstore->name ?? ''); ?> </td>
                                            <td> <?php echo e($d->transfer->tostore->name ?? ''); ?> </td>
                                            <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?></span> </td>
                                            <td> <?php echo e(number_format($d->shipping_charges)); ?> </td>
                                            <td> <?php echo e(number_format($d->final_total)); ?> </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <?php echo e($data->links('partials.return_pagination')); ?>

                                <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <form method="POST" action="<?php echo e(route('transfer.status')); ?>" class="modal-content">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id=""><?php echo e(__('general.change_status')); ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="system_name"><?php echo e(__('transfer.status')); ?></label>
                            <input type="hidden" name="id" id="ti" value="">
                            <select class="form-control" name="status">
                                <option value="complete"><?php echo e(__('transfer.complete')); ?></option>
                                <option value="transit"><?php echo e(__('transfer.transit')); ?></option>
                                <option value="pending"><?php echo e(__('transfer.pending')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i> <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i> <span class="d-none d-sm-block"><?php echo e(__('general.change_status')); ?></span>
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
            function getstatusmodal(id) {
                $("#ti").val(id);
                document.getElementById("update_status").click();
            }

            function getpaymentmodal(id) {
                $("#tri").val(id);
                document.getElementById("add_payment").click();
            }

            function movePage(url) {

                $("#transferContent").html("s");
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#transferContent').html(result);
                    }
                });
            }
            var supplier = null;
            var store = null;
            var status = null;
            var payment = null;
            var start = null;
            var end = null;

            function searchProduct() {
                var store = $("#store").val();
                var start = $("#start_date").val();
                var end = $("#end_date").val();
                var url = domainpath + '/pos-admin/stock-transfer/index?start_date=' + start + '&end_date=' + end + '';
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#transferContent').html(result);

                    }
                });
            }
        </script>
        <?php $__env->stopSection(); ?>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/stock_transfer/index.blade.php ENDPATH**/ ?>