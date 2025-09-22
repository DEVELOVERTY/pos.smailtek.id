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
                <td> <?php echo e($d->supplier->name ?? ''); ?> </td>
                <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?></span> <?php echo e($d->return); ?></td>
                <td> <span class=" badge bg-primary text-white"><?php echo e($payment[$d->payment_status]); ?></span>
                </td>
                <td> <?php echo e($d->pay_total); ?> </td>
                <td> <?php echo e(number_format($d->due_total ?? $d->final_total)); ?> </td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($data->links('partials.purchase_pagination')); ?>

    <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a>
    <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
    <a href="javascript:void(0)" class="d-none" id="update_payment" data-bs-toggle="modal" data-bs-target="#updatepayment"></a>
</div>
<?php /**PATH /var/www/pos/resources/views/admin/purchase/autoload_page.blade.php ENDPATH**/ ?>