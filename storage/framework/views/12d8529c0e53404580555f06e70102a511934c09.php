 <div class="table-responsive">

     <table class="table table-striped">
         <thead>
             <tr>
                 <th><?php echo e(__('general.action')); ?></th>
                 <th><?php echo e(__('general.date')); ?></th>
                 <th><?php echo e(__('general.ref_no')); ?></th>
                 <th><?php echo e(__('purchase.parent_transaction')); ?></th>
                 <th><?php echo e(__('general.store')); ?></th>
                 <th><?php echo e(__('sidebar.supplier')); ?></th>
                 <th><?php echo e(__('sell.total_return')); ?></th>
                 <th><?php echo e(__('general.total')); ?></th>
             </tr>
         </thead>
         <tbody>

             <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <tr>
                 <td>
                     <div class="btn-group mb-1">
                         <div class="dropdown">
                             <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="bi bi-error-circle me-50"></i> <?php echo e(__('general.action')); ?>

                             </button>
                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon" style="margin: 0px; z-index:1000">
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Return")): ?>
                                 <a class="dropdown-item" href="<?php echo e(route('return.detail', $d->id)); ?>">
                                     <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Return")): ?>
                                 <a target="_blank" class="dropdown-item" href="<?php echo e(route('return.print', $d->id)); ?>">
                                     <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Return")): ?>
                                 <?php if($d->due_total != '0'): ?>
                                 <a class="dropdown-item" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getpaymentmodal(this.id)">
                                     <i class="fas fa-money-bill-wave"></i> <?php echo e(__('general.add_payment')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <?php endif; ?>
                                 <a class="dropdown-item" href="javascript:void(0)">

                                 </a>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                 <td> <?php echo e($d->ref_no); ?> </td>
                 <td> <?php echo e($d->transaction->ref_no ?? ''); ?> </td>
                 <td> <?php echo e($d->store->name ?? ''); ?> </td>
                 <td> <?php echo e($d->supplier->name ?? ''); ?> </td>
                 <td> <?php echo e($d->qty_return); ?> Qty Return </td>
                 <td> <?php echo e(number_format($d->final_total)); ?> </td>
             </tr>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
     </table>

     <?php echo e($data->links('partials.return_pagination')); ?>

     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Pembayaran Return")): ?>
     <a href="javascript:void(0)" class="d-none" id="add_payment" data-bs-toggle="modal" data-bs-target="#addpay"></a>
     <?php endif; ?>
 </div>
<?php /**PATH /var/www/pos/resources/views/admin/return/autoload_page.blade.php ENDPATH**/ ?>