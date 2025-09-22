<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo e(__('general.action')); ?></th>
                <th><?php echo e(__('general.date')); ?></th>
                <th><?php echo e(__('general.ref_no')); ?></th>
                <th><?php echo e(__('general.store')); ?></th>
                <th><?php echo e(__('customer.name')); ?></th>
                <th><?php echo e(__('hrm.amount_total')); ?></th>
                <th><?php echo e(__('general.pay_amount')); ?></th>
                <th><?php echo e(__('general.sell_due_amount')); ?></th>
            </tr>
        </thead>
        <tbody>

            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="purchase_order">
                <td>
                    <div class="btn-group mb-1">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-error-circle me-50"></i> <?php echo e(__('general.action')); ?>

                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Hutang")): ?>
                                <a class="dropdown-item" href="<?php echo e(route('due.detail', $d->id)); ?>">
                                    <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Laporan Hutang")): ?>
                                <a target="_blank" class="dropdown-item" href="<?php echo e(route('due.print', $d->id)); ?>">
                                    <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("List Credit Hutang")): ?>
                                <a class="dropdown-item" href="<?php echo e(route('due.payment', $d->id)); ?>">
                                    <i class="fas fa-money-bill"></i><?php echo e(__('report.payment_list')); ?>

                                </a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="#">
                                    -
                                </a>
                            </div>
                        </div>
                    </div>
                </td>
                <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                <td> <?php echo e($d->ref_no); ?> </td>
                <td> <?php echo e($d->store->name ?? ''); ?> </td>
                <td> <?php echo e($d->customer->name ?? ''); ?> </td>
                <td> <?php echo e(number_format($d->final_total)); ?> </td>
                <td> <?php echo e($d->pay_total); ?> </td>
                <td> <?php echo e(number_format($d->due_total ?? $d->final_total)); ?> </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="5" style="height: 100px; font-size:30px"><?php echo e(__('general.total')); ?></th>
                <th><?php echo e(number_format($jumlahTotal)); ?></th>
                <th><?php echo e(number_format($jumlahTerbayar)); ?></th>
                <th><?php echo e(number_format($jumlahHutang)); ?></th>
            </tr>
        </tfoot>
    </table>

    <?php echo e($data->links('partials.purchase_pagination')); ?>

</div>
<?php /**PATH /var/www/pos/resources/views/admin/reports/transaction/due_page.blade.php ENDPATH**/ ?>