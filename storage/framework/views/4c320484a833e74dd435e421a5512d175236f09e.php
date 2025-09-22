<?php $__env->startSection('content'); ?> 

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Laporan Hutang')): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('due.report')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.debt_book')); ?></a>
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
                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" id="identity" value="<?php echo e($data->id); ?>">
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
                                <hr style="border: 2px solid black">
                                <div class="col-12">
                                    <h4><?php echo e(__('report.general_info')); ?></h4>
                                    <table class="table">
                                        <tr>
                                            <th><?php echo e(__('customer.name')); ?> : </th>
                                            <th><?php echo e($data->customer->name ?? ''); ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('purchase.date')); ?> : </th>
                                            <th><?php echo e(my_date($data->created_at)); ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('sell.due_total')); ?> : </th>
                                            <th> <?php echo e(my_currency($data->final_total)); ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo e(__('report.product_purchase')); ?> : </th>
                                            <th>
                                                <ul>
                                                    <?php $__currentLoopData = $data->sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li> <?php echo e($s->variation->product->name ?? ''); ?> <?php if($s->variation->name != 'no-name'): ?> <?php echo e(' - '. $s->variation->name ?? ''); ?> <?php endif; ?> - (<?php echo e(number_format($s->unit_price)); ?>)</li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  
                                                </ul>
                                            </th>
                                        </tr>
                                    </table>
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
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Hutang")): ?>
                                <a href="javascript:void(0)" id="<?php echo e($data->id); ?>" onclick="getpaymentmodal(this.id)" class="btn btn-sm btn-success float-end" style="margin-top: -5px; margin-right:5px; border: 2px solid white"><i class="fas fa-plus-circle"></i> <?php echo e(__('general.add_payment')); ?></a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Hutang")): ?>
                                <a href="javascript:void(0)"  id="<?php echo e($data->id); ?>" onclick="getstatusmodal(this.id)" class="btn btn-sm btn-success float-end" style="margin-top: -5px; margin-right:5px; border: 2px solid white"><i class="fas fa-check-circle"></i> <?php echo e(__('general.change_status')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" id="dueContent">
                             
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr> 
                                            <th><?php echo e(__('general.payment_date')); ?></th>
                                            <th><?php echo e(__('general.payment_total')); ?></th>
                                            <th><?php echo e(__('general.payment_note')); ?></th>
                                            <th><?php echo e(__('general.note')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $__currentLoopData = $payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="purchase_order">
                                                <?php
                                                    $method = '';
                                                    if ($d->method == 'cash') {
                                                        $method = 'Cash';
                                                    } elseif ($d->method == 'bank_transfer') {
                                                        $method = 'Bank Transfer';
                                                    } elseif ($pay->method == 'card') {
                                                        $method = 'Card';
                                                    } elseif ($d->method == 'other') {
                                                        $method = 'Lainnya';
                                                    }
                                                ?> 
                                                <td> <?php echo e($d->created_at); ?> </td>
                                                <td> <?php echo e(number_format($d->amount)); ?> </td>
                                                <td> <?php echo e($method); ?> </td>
                                                <td> <?php echo e($d->note); ?> </td>
                                                
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="3" style="height: 50px; font-size:25px"><?php echo e(__('general.sell_due_amount')); ?> : </th>
                                            <th style="font-size: 20px">Rp. <?php echo e($data->pay_total); ?></th> 
                                        </tr>
                                        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                            <th colspan="3" style="height: 50x; font-size:25px"><?php echo e(__('report.remaining_debt')); ?> : </th>
                                            <th style="font-size: 20px">Rp. <?php echo e(number_format($data->due_total)); ?></th> 
                                        </tr>
                                    </tfoot>
                                </table> 
                                <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
                                <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Hutang")): ?>
<div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="update-status"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <form method="POST" action="<?php echo e(route('purchase.status')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title" id=""><?php echo e(__('general.change_status')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="system_name"><?php echo e(__('general.payment_status')); ?></label>
                    <input type="hidden" name="id" id="ti" value="">
                    <select class="form-control" name="status">
                        <option value="final">Selesai</option>
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
                    <span class="d-none d-sm-block"><?php echo e(__('general.change_status')); ?></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Hutang")): ?>
<div class="modal fade" id="addpay" tabindex="-1" role="dialog" aria-labelledby="add-pay" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
        <form method="POST" action="<?php echo e(route('purchase.payment')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header header-modal ">
                <input type="hidden" name="transaction_id" id="tri" value="">
                <h5 class="modal-title text-white" id=""><?php echo e(__('general.add_payment')); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
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
                                    <input type="text" class="form-control" value="<?php echo e(date('Y-m-d H:i:s')); ?>" id="paid_date" name="paid_date" readonly="">
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
    <script>
       

        function getstatusmodal(id) {
            $("#ti").val(id);
            document.getElementById("update_status").click();
        }

        function getpaymentmodal(id) {
            $("#tri").val(id);
            document.getElementById("add_payment").click();
        }
        
        var start = null;
        var end = null;

        function searchProduct() { 
            var start = $("#start_date").val();
            var end = $("#end_date").val();
            var identity = $("#identity").val();
            var url = domainpath + '/pos-admin/report/transaction/due/payment/'+identity+'?start_date=' + start + '&end_date=' + end + '';
            console.log(url);
            spinner.show();
            setTimeout(function() {
                $.ajax({
                    url: url,
                    dataType: "html",
                    success: function(result) {
                        $('#dueContent').html(result);

                    }
                });
                spinner.hide();
            }, 130);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/reports/transaction/due_payment.blade.php ENDPATH**/ ?>