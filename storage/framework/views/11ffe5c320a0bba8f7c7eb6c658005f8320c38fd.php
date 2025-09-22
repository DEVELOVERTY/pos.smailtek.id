<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Penjualan")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('sell.report')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.sell_report')); ?></a>
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
                    <div class="card-content">
                        <div class="card-body" id="printarea">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <?php echo e(__('sidebar.customer')); ?> :
                                    <?php if(!empty($data->customer)): ?>     
                                    <address>
                                        <?php echo e($data->customer->name ?? ''); ?>,
                                        <?php echo e($data->customer->city ?? '' . ' ' . $data->customer->address ?? ''); ?>

                                        <br><?php echo e(__("general.phone")); ?>: <?php echo e($data->customer->phone ?? ''); ?> 
                                    </address>
                                    <?php endif; ?>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <?php echo e(__('general.store')); ?> :
                                    <address>
                                        <strong><?php echo e($data->store->name ?? ''); ?>,</strong>
                                        <br> <?php echo e($data->store->address); ?>

                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b><?php echo e(__('general.ref_no')); ?>:</b> #<?php echo e($data->ref_no); ?><br>
                                    <b><?php echo e(__('general.date')); ?>:</b> <?php echo e(my_date($data->created_at)); ?><br>
                                    <b><?php echo e(__('general.payment_status')); ?>:</b> <?php echo e($status[$data->status]); ?><br>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>#</th>
                                                    <th><?php echo e(__('produk.name')); ?></th>
                                                    <th><?php echo e(__('purchase.quantity')); ?> </th>
                                                    <th><?php echo e(__('general.sell_price')); ?></th>
                                                    <th class="text-right"><?php echo e(__('general.subtotal')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $jumlah = 0;
                                                ?>
                                                <?php $__currentLoopData = $data->sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php
                                                $subtotal = 0;
                                                $subtl = 0;

                                                $subtl += $gd->unit_price * $gd->qty;
                                                $jumlah += $subtl;
                                                $subtotal += $gd->unit_price * $gd->qty;
                                                ?>
                                                <tr>
                                                    <td><?php echo e($no++); ?></td>
                                                    <td> <?php echo e($gd->variation->product->name ?? ''); ?> <?php if($gd->variation->name != 'no-name'): ?> <?php echo e(' - '. $gd->variation->name ?? ''); ?> <?php endif; ?> </td>
                                                    <td> <?php echo e($gd->qty); ?> </td>
                                                    <td><?php echo e(number_format($gd->unit_price)); ?> </td>
                                                    <td><?php echo e(number_format($subtotal)); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <h4><?php echo e(__('general.payment_info')); ?>:</h4>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                    <th>#</th>
                                                    <th><?php echo e(__('general.date')); ?></th>
                                                    <th><?php echo e(__('general.ref_no')); ?></th>
                                                    <th><?php echo e(__('general.payment_total')); ?></th>
                                                    <th><?php echo e(__('general.payment_method')); ?></th>
                                                    <th><?php echo e(__('general.payment_note')); ?></th>
                                                </tr>
                                                <?php
                                                if(count($data->paycredit) == 0) {
                                                echo ' <tr>
                                                    <td colspan="5" class="text-center">No payments found </td>
                                                </tr>';
                                                } else {
                                                foreach ($data->paycredit as $pay) {
                                                if($pay->method == 'cash') {
                                                $method = 'Cash';
                                                } else if($pay->method == 'bank_transfer') {
                                                $method = 'Bank Transfer';
                                                } else if($pay->method == 'card') {
                                                $method = 'Card';
                                                } else if($pay->method == 'other') {
                                                $method = __('report.other');
                                                }
                                                echo '<tr>
                                                    <td>#</td>
                                                    <td>'.$pay->created_at.'</td>
                                                    <td>'.$data->ref_no.'</td>
                                                    <td>'.number_format($pay->amount).'</td>
                                                    <td>'.$method.'</td>
                                                    <td>'.$pay->note.'</td>
                                                </tr>';
                                                }
                                                }
                                                ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th><?php echo e(__('purchase.net_total')); ?>: </th>
                                                    <td></td>
                                                    <td><?php echo e(number_format($jumlah)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.discount_total')); ?>:</th>
                                                    <td>
                                                        <b>(-)</b>
                                                    </td>
                                                    <td> <?php echo e(number_format($data->discount_amount)); ?>%</td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.tax')); ?>:</th>
                                                    <td><b>(+)</b></td>
                                                    <td class="text-right">
                                                        <?php echo e(number_format($data->tax_amount)); ?>%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.shipping_cost')); ?>:</th>
                                                    <td><b>(+)</b></td>
                                                    <td><?php echo e(number_format($data->shipping_charges)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.other_payment')); ?>:</th>
                                                    <td><b>(+)</b></td>
                                                    <td><?php echo e(number_format($data->other_charges)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('general.total')); ?>:</th>
                                                    <td></td>
                                                    <td><?php echo e(number_format($data->final_total)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Penjualan")): ?>
                                    <a target="_blank" href="<?php echo e(route('sell.print',$data->id)); ?>" class="btn btn-primary"><i class="fas fa-print"></i> <?php echo e(__('general.print')); ?></a>
                                    <?php endif; ?>
                                    <a href="javascript:void(0)" id="<?php echo e($data->id); ?>" onclick="printcepeipt(this.id)" class="btn btn-primary"><i class="fas fa-print"></i> <?php echo e(__('pos.print')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function printcepeipt(id) {
        $.ajax({
            type: "GET",
            url: domainpath + "/pos/print/" + id,
            data: ""
        }).done(function(msg) {

        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/reports/transaction/sell_detail.blade.php ENDPATH**/ ?>