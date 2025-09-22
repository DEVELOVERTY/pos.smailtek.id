<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th><?php echo e(__('produk.name')); ?></th>
                <th><?php echo e(__('general.store')); ?></th>
                <th><?php echo e(__('report.total_stock')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="purchase_order">
                <td><?php echo e($no++); ?></td>
                <td> <?php echo e($d->product_name); ?> - <?php echo e($d->variation_name); ?> </td>
                <td> <?php echo e($d->store_name); ?> </td>
                <td> <?php echo e(number_format($d->stok)); ?> </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

    </table>
    <?php echo e($data->links('partials.purchase_pagination')); ?>

</div><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/reports/stock/all_page.blade.php ENDPATH**/ ?>