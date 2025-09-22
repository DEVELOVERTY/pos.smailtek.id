<table class="table table-striped">
    <thead>
        <tr>
            <th colspan="6" style="background-color: yellow; text-align:center; font-size: 30px; height: 50px; font-weight:50;"><b><?php echo e(__('sidebar.stock_adjs')); ?></b></th>
        </tr>
        <tr>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('general.date')); ?></th>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('general.store')); ?></th>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('general.type')); ?></th>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('report.qty_product')); ?></th>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('adjustment.amount_total')); ?></th>
            <th style="width: 20px; text-align:center; height: 40px;"><?php echo e(__('adjustment.amount_recovered')); ?></th>
        </tr>
        <tr>
            <th style="text-align: center; background-color:#3c8dbc; color:white">1</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">2</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">3</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">4</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">5</th>
            <th style="text-align: center; background-color:#3c8dbc; color:white">6</th>
        </tr>
    </thead>
    <tbody>

        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td> <?php echo e($d->created_at); ?></td>
            <td> <?php echo e($d->store->name ?? ''); ?> </td>
            <td> <b> <?php echo e($d->adjustment_type); ?></b> </td>
            <td> <b><?php echo e(count($d->adjustment)); ?> Product</b> | <b><?php echo e($d->adjustment_qty); ?> Qty</b> </td>
            <td> <?php echo e(number_format($d->final_total)); ?> </td>
            <td> <?php echo e(number_format($d->total_amount_recovered)); ?> </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <tfoot>
        <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
            <th colspan="5" style="height: 30px; font-size:20px; background-color:#5cb85c; text-align:center;"><?php echo e(__('general.total')); ?></th>
            <th style="text-align:right;"> <b><?php echo e(my_currency($jumlah)); ?></b></th>
        </tr>
    </tfoot>
</table><?php /**PATH /var/www/pos/resources/views/admin/export/reports/adjustment.blade.php ENDPATH**/ ?>