<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($page); ?></title>
    <?php echo $__env->yieldContent('styles'); ?>
   <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.svg')); ?>" type="image/x-icon">
    <style type="text/css">
       
        @media    print{
           

        }
    </style>
    <script>window.print()</script>
</head>

<body> 
   <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card"> 
                <div class="card-content">
                    <div class="card-body" id="printarea">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="pull-right"><b><?php echo e(__('general.date')); ?> :</b> <?php echo e(my_date($transfer->created_at)); ?> </p> 
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-6 ">
                                <?php echo e(__('transfer.from')); ?> :
                                <address>
                                    <?php echo e($transfer->transfer->fromstore->name ?? ''); ?>, 
                                    <br><?php echo e(__('general.phone')); ?> : <?php echo e($transfer->transfer->fromstore->phone ?? ''); ?>

                                    <br><?php echo e(__('general.address')); ?> : <?php echo e($transfer->transfer->fromstore->address ?? ''); ?>

                                </address>
                            </div>

                            <div class="col-sm-6 ">
                                <?php echo e(__('transfer.to')); ?> :
                                <address>
                                    <strong><?php echo e($transfer->transfer->tostore->name ?? ''); ?>,</strong>
                                    <br><?php echo e(__('general.phone')); ?> : <?php echo e($transfer->transfer->tostore->phone ?? ''); ?>

                                    <br><?php echo e(__('general.address')); ?> : <?php echo e($transfer->transfer->tostore->address ?? ''); ?>

                                </address>
                            </div>
 
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('produk.name')); ?></th>
                                                <th><?php echo e(__('purchase.quantity')); ?></th>
                                                <th><?php echo e(__('purchase.unit_cost')); ?></th>
                                                <th class="text-right"><?php echo e(__('general.subtotal')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            $jumlah = 0;
                                            ?> 
                                        <?php $__currentLoopData = $transfer->manytransfer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <?php 
                                        $subtotal = 0;
                                        $subtl = 0; 
                                        $subtl += $gd->stock->variation->purchase_price * $gd->transfer_qty;
                                        $jumlah += $subtl; 
                                        ?> 
                                        <?php if($gd->transfer_qty != 0): ?>
                                        <tr>
                                            <td><?php echo e($no++); ?></td>
                                            <td>
                                               <?php echo e($gd->stock->variation->product->name ?? ''); ?> <?php if($gd->stock->variation->name != 'no-name'): ?> <?php echo e(' - '. $gd->stock->variation->name ?? ''); ?> <?php endif; ?>
                                            </td>
                                            <td> <?php echo e($gd->transfer_qty); ?>  </td>
                                            <td> <?php echo e(number_format($gd->stock->variation->purchase_price)); ?>  </td>  
                                            <td><?php echo e(number_format($subtl)); ?></td> 
                                        </tr> 
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row"> 
                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="table-responsive">
                                    <table class="table"> 
                                        <tbody>
                                            <tr>
                                                <th><?php echo e(__('purchase.shipping_cost')); ?> : </th>
                                                <td></td>
                                                <td><?php echo e(number_format($transfer->shipping_charges)); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__('purchase.net_total')); ?> : </th>
                                                <td></td>
                                                <td><?php echo e(number_format($jumlah)); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__('general.total')); ?> : </th>
                                                <td></td>
                                                <td><?php echo e(number_format($transfer->final_total)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                          
                         <div class="row text-center mt-5 mb-3">
                            <div class="col-12">
                                <img class="center-block" src="data:image/png;base64, <?php echo e(DNS1D::getBarcodePNG($transfer->ref_no, 'C39')); ?>">
                                <p ><b><?php echo e($transfer->ref_no); ?></b></p>
                            </div>
                        </div> 
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH /var/www/pos/resources/views/admin/stock_transfer/print.blade.php ENDPATH**/ ?>