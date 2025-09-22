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
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Download Stock Transfer")): ?>
                                <a href="<?php echo e(route('transfer.download')); ?>" class="btn btn-sm btn-success float-end" style="margin-top: -5px; border: 2px solid white"><i class="fas fa-download"></i> <?php echo e(__('report.download_excel')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="transferContent">
                            

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('general.date')); ?></th>
                                            <th><?php echo e(__('transfer.from')); ?></th>
                                            <th><?php echo e(__('transfer.to')); ?></th>
                                            <th><?php echo e(__('transfer.status')); ?></th>
                                            <th><?php echo e(__('purchase.shipping_cost')); ?></th>
                                            <th><?php echo e(__('report.qty_product')); ?></th>
                                            <th><?php echo e(__('general.total')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td> <?php echo e($d->created_at); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                                            <td> <?php echo e($d->transfer->fromstore->name ?? ''); ?> </td>
                                            <td> <?php echo e($d->transfer->tostore->name ?? ''); ?> </td>
                                            <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?></span> </td>
                                            <td> <?php echo e(number_format($d->shipping_charges)); ?> </td>
                                            <td> <span class=" badge bg-primary text-white"><?php echo e(count($d->manytransfer)); ?> Product</span> <span class=" badge bg-primary text-white"><?php echo e($d->transfer_qty); ?> Quantity</span> </td>
                                            <td> <?php echo e(number_format($d->final_total)); ?> </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="6" style="height: 100px; font-size:30px"><?php echo e(__('general.total')); ?></th>
                                            <th> <?php echo e(my_currency($jumlah)); ?></th>
                                        </tr>
                                    </tfoot>
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
    var start = null;
    var end = null;

    function searchProduct() {
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/report/stock-product/transfer?start_date=' + start + '&end_date=' + end + '';
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/reports/stock/transfer.blade.php ENDPATH**/ ?>