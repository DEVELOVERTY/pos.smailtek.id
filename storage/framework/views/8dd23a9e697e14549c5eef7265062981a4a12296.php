<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo e(__('general.action')); ?></th>
                <th><?php echo e(__('general.date')); ?></th>
                <th><?php echo e(__('general.ref_no')); ?></th>
                <th><?php echo e(__('general.store')); ?></th>
                <th><?php echo e(__('customer.name')); ?></th>
                <th><?php echo e(__('general.payment_status')); ?></th>
                <th><?php echo e(__('report.product_sell')); ?></th>
                <th><?php echo e(__('report.qty_sell')); ?></th>
                <th><?php echo e(__('hrm.amount_total')); ?></th>
                <th><?php echo e(__('general.pay_amount')); ?></th>
                <th><?php echo e(__('general.sell_due_amount')); ?></th>
                <th><?php echo e(__('report.profit_amount')); ?></th>
                <th><?php echo e(__('report.createdby')); ?></th>
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
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Penjualan")): ?>
                                <a class="dropdown-item" href="<?php echo e(route('sell.detail', $d->id)); ?>">
                                    <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Penjualan")): ?>
                                <a target="_blank" class="dropdown-item" href="<?php echo e(route('sell.print', $d->id)); ?>">
                                    <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Return Penjualan")): ?>
                                <a class="dropdown-item" href="<?php echo e(route('returnsell.create', $d->id)); ?>">
                                    <i class="fas fa-redo"></i> <?php echo e(__('sell.return_sell')); ?>

                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Penjualan")): ?>
                                <?php if($d->due_total != '0'): ?>
                                <a class="dropdown-item" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getpaymentmodal(this.id)">
                                    <i class="fas fa-money-bill-wave"></i> <?php echo e(__('general.add_payment')); ?>

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
                <td> <?php echo e($d->customer->name ?? ''); ?> </td>
                <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?> </span> </td>
                <td> <span class=" badge bg-primary text-white"><?php echo e(count($d->sell)); ?></span> <?php echo e($d->return_sell); ?></td>
                <td> <span class=" badge bg-primary text-white">0</span> </td>
                <td> <?php echo e(number_format($d->final_total)); ?> </td>
                <td> <?php echo e($d->pay_total); ?> </td>
                <td> <?php echo e(number_format($d->due_total ?? $d->final_total)); ?> </td>
                <td> <?php echo e(number_format($d->profit)); ?> </td>
                <td> <?php echo e($d->createdby->name ?? ''); ?> </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <tfoot>
            <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                <th colspan="9" style="height: 100px; font-size:30px"><?php echo e(__('report.total_income')); ?> : <?php echo e(number_format($jumlahProfit)); ?></th>
                <th><?php echo e(number_format($jumlahTotal)); ?></th>
                <th><?php echo e(number_format($jumlahTerbayar)); ?></th>
                <th><?php echo e(number_format($jumlahHutang)); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <?php echo e($data->links('partials.purchase_pagination')); ?>

    <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
</div><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/reports/transaction/sell_page.blade.php ENDPATH**/ ?>