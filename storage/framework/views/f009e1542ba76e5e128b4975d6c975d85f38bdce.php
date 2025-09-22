
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
                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <option value=""><?php echo e(__('general.choose_store')); ?></option>
                                            <div class="input-group">
                                                <select class="form-control" id="store" name="store">
                                                    <option value=""><?php echo e(__('general.choose_store')); ?></option>
                                                    <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($st->id); ?>" <?php if(isset($_GET['store'])): ?> <?php if($st->id==$_GET['store']): ?> selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($st->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="control-label"><?php echo e(__('general.start_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-3">
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
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                            </div>
                            <div class="col-6">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Download Laporan Return")): ?>
                                <a href="<?php echo e(route('returnsell.download')); ?>" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i> <?php echo e(__("report.download_excel")); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="returnContent">
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('general.action')); ?></th>
                                            <th><?php echo e(__('general.date')); ?></th>
                                            <th><?php echo e(__('general.ref_no')); ?></th>
                                            <th><?php echo e(__('general.store')); ?></th>
                                            <th><?php echo e(__('customer.name')); ?></th>
                                            <th><?php echo e(__('report.return_qty')); ?></th>
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
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Return Sales")): ?>
                                                            <a class="dropdown-item" href="<?php echo e(route('returnsell.detail', $d->id)); ?>">
                                                                <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Return Sales")): ?>
                                                            <a target="_blank" class="dropdown-item" href="<?php echo e(route('returnsell.print', $d->id)); ?>">
                                                                <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <a class="dropdown-item" href="javascript:void(0)">

                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                                            <td> <?php echo e($d->ref_no); ?> </td>
                                            <td> <?php echo e($d->store->name ?? ''); ?> </td>
                                            <td> <?php echo e($d->customer->name ?? ''); ?> </td>
                                            <td> <?php echo e(count($d->sellreturn)); ?> </td>
                                            <td> <?php echo e(number_format($d->final_total)); ?> </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>

                                </table>

                                <?php echo e($data->links('partials.return_pagination')); ?>


                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.js')); ?>"></script>
<script>
    function getpaymentmodal(id) {
        $("#tri").val(id);
        document.getElementById("add_payment").click();
    }

    function movePage(url) {
        spinner.show();
        setTimeout(function() {
            $("#sellContent").html("s");
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#sellContent').html(result);
                }
            });
            spinner.hide();
        }, 130)

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
        var url = domainpath + '/pos-admin/return-sell?store=' + store + '&start_date=' + start + '&end_date=' + end + '';
        spinner.show();
        setTimeout(function() {
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#returnContent').html(result);

                }
            });
            spinner.hide();
        }, 140)

    }
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tymart\resources\views/admin/returnsell/index.blade.php ENDPATH**/ ?>