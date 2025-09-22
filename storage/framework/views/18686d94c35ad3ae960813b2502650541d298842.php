<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Purchase")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('purchase.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.purchase')); ?></a>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="pull-right"><b><?php echo e(__('general.date')); ?> : </b> <?php echo e(my_date($purchase->created_at)); ?> </p>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <?php echo e(__('sidebar.supplier')); ?>:
                                    <address>
                                        <?php echo e($purchase->supplier->name); ?>,
                                        <?php echo e($purchase->supplier->city . ' ' . $purchase->supplier->address); ?>

                                        <br><?php echo e(__('general.phone')); ?> : <?php echo e($purchase->supplier->phone); ?>

                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <?php echo e(__('general.store')); ?> :
                                    <address>
                                        <strong><?php echo e($purchase->store->name); ?>,</strong>
                                        <br> <?php echo e($purchase->store->address); ?>

                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b><?php echo e(__('general.ref_no')); ?> : </b> #<?php echo e($purchase->ref_no); ?><br>
                                    <b><?php echo e(__('general.date')); ?> : </b> <?php echo e($purchase->created_at); ?><br>
                                    <b><?php echo e(__('purchase.received_status')); ?> :</b> <?php echo e($status[$purchase->status]); ?><br>
                                    <b><?php echo e(__('general.payment_status')); ?> :</b> <?php echo e($payment[$purchase->payment_status]); ?><br>
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
                                                    <th><?php echo e(__('produk.code')); ?></th>
                                                    <th><?php echo e(__('purchase.quantity')); ?> </th>
                                                    <th><?php echo e(__('purchase.unit_cost')); ?> (<span style="font-size: 10px;"><?php echo e(__('purchase.before_discount')); ?></span>)</th>
                                                    <th><?php echo e(__('purchase.discount_percentase')); ?></th>
                                                    <th><?php echo e(__('purchase.tax')); ?></th>
                                                    <th><?php echo e(__('purchase.unit_cost')); ?> (<span style="font-size: 10px;"><?php echo e(__('purchase.before_tax')); ?></span>)</th>
                                                    <th><?php echo e(__('purchase.unit_cost')); ?> (<span style="font-size: 10px;"><?php echo e(__('purchase.after_tax')); ?></span>)</th>
                                                    <th class="text-right"><?php echo e(__('general.sell_price')); ?></th>
                                                    <th class="text-right"><?php echo e(__('general.subtotal')); ?> (<span style="font-size: 10px;"><?php echo e(__('purchase.before_tax')); ?></span>)</th>
                                                    <th class="text-right"><?php echo e(__('general.subtotal')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $jumlah = 0;
                                                ?>
                                                <?php $__currentLoopData = $getDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php
                                                $subtotal = 0;
                                                $subtl = 0;

                                                $subtl += $gd->purchase_price * $gd->quantity;
                                                $jumlah += $subtl;
                                                $subtotal += $gd->purchase_price_inc_tax * $gd->quantity;
                                                ?>
                                                <tr>
                                                    <td><?php echo e($no++); ?></td>
                                                    <td>
                                                        <?php echo e($gd->variation->product->name ?? ''); ?> <?php if($gd->variation->name != 'no-name'): ?> <?php echo e(' - '. $gd->variation->name ?? ''); ?> <?php endif; ?>
                                                    </td>
                                                    <td> <?php echo e($gd->variation->sku ?? ''); ?> </td>
                                                    <td> <?php echo e($gd->quantity); ?> </td>
                                                    <td><?php echo e(number_format($gd->without_discount)); ?> </td>
                                                    <td> <?php echo e($gd->discount_percent); ?> %</td>
                                                    <td><?php echo e($gd->item_tax); ?></td>
                                                    <td> <?php echo e(number_format($gd->purchase_price)); ?> </td>
                                                    <td> <?php echo e(number_format($gd->purchase_price_inc_tax)); ?> </td>
                                                    <td> <?php echo e(number_format($gd->variation->selling_price)); ?></td>
                                                    <td> <?php echo e(number_format($subtl)); ?></td>
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
                                    <h4><?php echo e(__('general.payment_info')); ?> :</h4>
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
                                                if(count($purchase->paycredit) == 0) {
                                                echo ' <tr>
                                                    <td colspan="5" class="text-center">No payments found </td>
                                                </tr>';
                                                } else {
                                                foreach ($purchase->paycredit as $pay) {
                                                if($pay->method == 'cash') {
                                                $method = 'Cash';
                                                } else if($pay->method == 'bank_transfer') {
                                                $method = 'Bank Transfer';
                                                } else if($pay->method == 'card') {
                                                $method = 'Card';
                                                } else if($pay->method == 'other') {
                                                $method = 'Lainnya';
                                                }
                                                echo '<tr>
                                                    <td>#</td>
                                                    <td>'.$pay->created_at.'</td>
                                                    <td>'.$purchase->ref_no.'</td>
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
                                                    <th><?php echo e(__('purchase.net_total')); ?> : </th>
                                                    <td></td>
                                                    <td><?php echo e(number_format($jumlah)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.discount_amount')); ?> :</th>
                                                    <td>
                                                        <b>(-)</b>
                                                    </td>
                                                    <td> <?php echo e(number_format($purchase->discount_amount)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.purchase_tax')); ?> :</th>
                                                    <td><b>(+)</b></td>
                                                    <td class="text-right">
                                                        <?php echo e(number_format($purchase->tax_amount)); ?>%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('purchase.shipping_cost')); ?> :</th>
                                                    <td><b>(+)</b></td>
                                                    <td><?php echo e(number_format($purchase->shipping_charges)); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo e(__('general.total')); ?> :</th>
                                                    <td></td>
                                                    <td><?php echo e(number_format($purchase->final_total)); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><?php echo e(__('purchase.shipping_detail')); ?>:</strong><br>
                                    <?php if($purchase->shipping_details != null): ?>
                                    <p style="background-color: #d2d6de; border-radius:10px;" class="p-2">
                                        <?php echo e($purchase->shipping_details); ?>

                                    </p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong><?php echo e(__('general.note')); ?> :</strong><br>
                                    <?php if($purchase->additional_notes != null): ?>
                                    <p style="background-color: #d2d6de; border-radius:10px;" class="p-2">
                                        <?php echo e($purchase->additional_notes); ?>

                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div> 
                            <div class="row text-center mt-5 mb-3">
                                <div class="col-xs-12">
                                    <img class="center-block" src="data:image/png;base64, <?php echo e(DNS1D::getBarcodePNG($purchase->ref_no, 'C39')); ?>">
                                    <p><b><?php echo e($purchase->ref_no); ?></b></p>
                                </div>
                            </div>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Purchase")): ?>
                            <div class="row text-center mt-5 mb-3">
                                <div class="col-12">
                                    <a target="_blank" href="<?php echo e(route('purchase.print',$purchase->id)); ?>" class="btn btn-primary"><i class="fas fa-print"></i> <?php echo e(__('purchase.print')); ?> </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/purchase/detail.blade.php ENDPATH**/ ?>