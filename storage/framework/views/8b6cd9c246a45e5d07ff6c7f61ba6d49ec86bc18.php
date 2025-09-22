<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="12" style="background-color: yellow; text-align:center; font-size: 30px; height: 50px; font-weight:50;"><b><?php echo e(__('sidebar.sell_report')); ?></b></th>
        </tr>
        <tr>
            <th style="width: 20px; text-align:center; height: 40px;"><b><?php echo e(__('general.date')); ?></b></th>
            <th style="width: 20px; text-align:center"><b><?php echo e(__('general.ref_no')); ?></b></th>
            <th style="width: 20px; text-align:center"><b><?php echo e(__('general.store')); ?></b></th>
            <th style="width: 20px; text-align:center"><b><?php echo e(__('customer.name')); ?></b></th>
            <th style="width: 20px; text-align:center"><b><?php echo e(__('general.payment_status')); ?></b></th>
            <th style="width: 20px; text-align:center"><b><?php echo e(__('report.product_sell')); ?></b></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('report.qty_sell')); ?></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('hrm.amount_total')); ?></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('general.pay_amount')); ?></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('general.payment_method')); ?></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('general.sell_due_amount')); ?></th>
            <th style="width: 20px; text-align:center"><?php echo e(__('report.profit_amount')); ?></th> 
            <th style="width: 20px; text-align:center"><?php echo e(__('report.createdby')); ?></th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#3c8dbc; color:white">1</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">2</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">3</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">4</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">5</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">6</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">7</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">8</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">9</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">10</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">11</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">12</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">13</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td> <?php echo e($d->created_at); ?></td>
            <td style="text-align:left;"> <?php echo e($d->ref_no); ?> </td>
            <td style="text-align:left;"> <?php echo e($d->store->name ?? ''); ?> </td>
            <td style="text-align:left;"> <?php echo e($d->customer->name ?? ''); ?> </td>
            <td style="text-align:left;"><?php echo e($status[$d->status]); ?> </td>
            <td style="text-align:left;"><?php echo e(count($d->sell)); ?></td>
            <td style="text-align:left;"> <?php echo e($d->qty_sell); ?></td>
            <td style="text-align:right;"> <?php echo e(number_format($d->final_total)); ?> </td>
            <td style="text-align:right;"> <?php echo e($d->pay_total); ?> </td>
            <td style="text-align:left;"> <?php echo e($d->method); ?> </td>
            <td style="text-align:right;"> <?php echo e(number_format($d->due_total ?? $d->final_total)); ?> </td>
            <td style="text-align:right;"> <?php echo e(number_format($d->profit)); ?> </td> 
            <td style="text-align:right;"> <?php echo e($d->createdby->name ?? ''); ?> </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
    <tfoot>
        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
            <th colspan="7" style="height: 30px; font-size:20px; background-color:#5cb85c; text-align:center;"><b><?php echo e(__('report.total_income')); ?> : <?php echo e(number_format($jumlahProfit)); ?></b></th>
            <th style="text-align:right;"><b><?php echo e(number_format($jumlahTotal)); ?></b></th>
           
            <th style="text-align:right;"><b><?php echo e(number_format($jumlahTerbayar)); ?></b></th>
            <th style="text-align:right;"></th>
            <th style="text-align:right;"><b><?php echo e(number_format($jumlahHutang)); ?></b></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
<?php /**PATH /var/www/tymart/resources/views/admin/export/reports/selling.blade.php ENDPATH**/ ?>