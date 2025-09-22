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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Purchase")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('purchase.create')); ?>"><i class="fa fa-plus"></i> <?php echo e(__('sidebar.add_purchase')); ?></a>
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
                                        <div class="col-sm-6 col-md-4 mb-4">
                                            <div class="input-group">
                                                <select class="form-control" id="supplier" name="supplier">
                                                    <option value=""><?php echo e(__('general.choose_supplier')); ?></option>
                                                    <?php $__currentLoopData = $supplier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($s->id); ?>" <?php if(isset($_GET['supplier'])): ?> <?php if($s->id==$_GET['supplier']): ?>
                                                        selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($s->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4 mb-4">
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

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <div class="input-group">
                                                <select class="form-control" id="status" name="status">
                                                    <option value=""><?php echo e(__('purchase.received_status')); ?></option>
                                                    <option value="received"><?php echo e(__('purchase.received')); ?></option>
                                                    <option value="pending"><?php echo e(__('purchase.pending')); ?></option>
                                                    <option value="ordered"><?php echo e(__('purchase.ordered')); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <label class="control-label"><?php echo e(__('general.payment_status')); ?></label>
                                            <div class="input-group">
                                                <select class="form-control" id="payment" name="payment">
                                                    <option value=""><?php echo e(__('general.payment_status')); ?></option>
                                                    <option value="due"><?php echo e(__('general.po_due')); ?></option>
                                                    <option value="paid"><?php echo e(__('general.paid')); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
                                            <label class="control-label"><?php echo e(__('general.start_date')); ?></label>
                                            <div class="input-group">
                                                <input type="date" name="start_date" id="start_date" placeholder="Mulai Tanggal" class="form-control" value="<?php echo e(old('start_date')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-4">
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
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="purchaseContent">
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('general.action')); ?></th>
                                            <th><?php echo e(__('general.date')); ?></th>
                                            <th><?php echo e(__('general.ref_no')); ?></th>
                                            <th><?php echo e(__('general.store')); ?></th>
                                            <th><?php echo e(__('supplier.name')); ?></th>
                                            <th><?php echo e(__('purchase.received_status')); ?></th>
                                            <th><?php echo e(__('general.payment_status')); ?></th>
                                            <th><?php echo e(__('general.pay_amount')); ?></th>
                                            <th><?php echo e(__('general.po_due_amount')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="purchase_order">
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="bi bi-error-circle me-50"></i> Action </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Purchase")): ?>
                                                            <a class="dropdown-item" href="<?php echo e(route('purchase.detail', $d->id)); ?>">
                                                                <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Purchase")): ?>
                                                            <a target="_blank" class="dropdown-item" href="<?php echo e(route('purchase.print', $d->id)); ?>">
                                                                <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php if($d->status != 'received'): ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Purchase")): ?>
                                                            <a class="dropdown-item po-edit" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getstatusmodal(this.id)">
                                                                <i class="fas fa-check-circle"></i> <?php echo e(__('general.change_status')); ?>

                                                            </a>
                                                            <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if($d->payment_status == 'due'): ?>
                                                            <?php if($d->due_total < $d->pay_total): ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Purchase")): ?>
                                                                <a class="dropdown-item po-edit" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getstatuspayment(this.id)">
                                                                    <i class="fas fa-money-bill-wave"></i> <?php echo e(__('purchase.change_payment_status')); ?>

                                                                </a>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if($d->due_total != '0'): ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Purchase")): ?>
                                                                <a class="dropdown-item" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getpaymentmodal(this.id)">
                                                                    <i class="fas fa-money-bill-wave"></i> <?php echo e(__('general.add_payment')); ?>

                                                                </a>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Produk Label")): ?>
                                                                <a class="dropdown-item" href="<?php echo e(route('barcode.purchase',$d->id)); ?>">
                                                                    <i class="fas fa-barcode"></i> <?php echo e(__('produk.print_label')); ?>

                                                                </a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Return")): ?>
                                                                <?php if($d->status == 'received'): ?>
                                                                <a class="dropdown-item" href="<?php echo e(route('return.po',$d->id)); ?>">
                                                                    <i class="fas fa-redo"></i> <?php echo e(__('purchase.return')); ?>

                                                                </a>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                                            <td> <?php echo e($d->ref_no); ?> </td>
                                            <td> <?php echo e($d->store->name ?? ''); ?> </td>
                                            <td> <?php echo e($d->supplier->name ?? ''); ?> </td>
                                            <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?></span> <?php echo e($d->return); ?></td>
                                            <td> <span class=" badge bg-primary text-white"><?php echo e($payment[$d->payment_status]); ?></span> </td>
                                            <td> <?php echo e($d->pay_total); ?> </td>
                                            <td> <?php echo e(number_format($d->due_total ?? $d->final_total)); ?> </td>

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <?php echo e($data->links('partials.purchase_pagination')); ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Update Status Purchase')): ?>
                                <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
                                <a href="javascript:void(0)" class="d-none" id="update_payment" data-bs-toggle="modal" data-bs-target="#updatepayment"></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Tambah Pembayaran Purchase')): ?>
                                <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
                                <?php endif; ?>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Purchase")): ?>
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('purchase.status')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id=""><?php echo e(__('general.change_status')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name"><?php echo e(__('purchase.received_status')); ?></label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="received"><?php echo e(__('purchase.received')); ?></option>
                        <option value="order"><?php echo e(__('purchase.ordered')); ?></option>
                        <option value="pending"><?php echo e(__('purchase.pending')); ?></option>
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
                    <span class="d-none d-sm-block"><?php echo e(__('general.save')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="updatepayment" tabindex="-1" role="dialog" aria-labelledby="update-payment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('purchase.payment_status')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id=""><?php echo e(__('purchase.change_payment_status')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name"><?php echo e(__('general.payment_status')); ?></label>
                    <input type="hidden" name="id" id="up" value="">
                    <select class="form-control" name="payment_status">
                        <option value="paid"><?php echo e(__('general.paid')); ?></option>
                        <option value="due"><?php echo e(__('general.po_due')); ?></option>
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
                    <span class="d-none d-sm-block"><?php echo e(__('general.save')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Purchase")): ?>
<div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
        <form method="POST" action="<?php echo e(route('purchase.payment')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header header-modal ">
                <input type="hidden" name="transaction_id" id="tri" value="">
                <h5 class="modal-title text-white" id=""><?php echo e(__('general.add_payment')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <i data-feather="x"></i> </button>
            </div>
            <div class="modal-body">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="row" id="paymentsession">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('general.payment_method')); ?></label>
                                <select class="choices form-select" name="payment_method" id="payment_method">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="card">Card</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('general.payment_date')); ?></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="<?php echo e(date("Y-m-d H:i:s")); ?>" id="paid_date" name="paid_date" readonly="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row" id="paymentprocess">
                                    <div class="col-md-6 form-group">
                                        <label><?php echo e(__('general.payment_total')); ?></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" value="0" id="payment_amount" name="payment_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><?php echo e(__('general.payment_note')); ?></label>
                                <textarea class="form-control" name="payment_note"></textarea>
                            </div>
                        </div>
                        <br>
                    </div>
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
<?php endif; ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/datatables/datatables.js')); ?>"></script>
<script>
    function getstatusmodal(id) {
        $("#ti").val(id);
        document.getElementById("update_status").click();
    }

    function getstatuspayment(id) {
        $("#up").val(id);
        document.getElementById("update_payment").click();
    }

    function getpaymentmodal(id) {
        $("#tri").val(id);
        document.getElementById("add_payment").click();
    }

    function movePage(url) {

        $("#purchaseContent").html("s");
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#purchaseContent').html(result);
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
        var supplier = $("#supplier").val();
        var store = $("#store").val();
        var status = $("#status").val();
        var payment = $("#payment").val();
        var start = $("#start_date").val();
        var end = $("#end_date").val();
        var url = domainpath + '/pos-admin/purchase/index?supplier=' + supplier + '&store=' + store + '&status=' + status +
            '&payment=' + payment + '&start_date=' + start + '&end_date=' + end + '';
        $.ajax({
            url: url,
            dataType: "html",
            success: function(result) {
                $('#purchaseContent').html(result);

            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/purchase/index.blade.php ENDPATH**/ ?>