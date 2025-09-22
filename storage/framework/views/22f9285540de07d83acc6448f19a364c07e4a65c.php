 <div class="table-responsive">
     <table class="table table-striped">
         <thead>
             <tr>
                 <th><?php echo e(__('general.action')); ?></th>
                 <th><?php echo e(__('general.date')); ?></th>
                 <th><?php echo e(__('general.ref_no')); ?></th>
                 <th><?php echo e(__('transfer.from')); ?></th>
                 <th><?php echo e(__('transfer.to')); ?></th>
                 <th><?php echo e(__('transfer.status')); ?></th>
                 <th><?php echo e(__('purchase.shipping_cost')); ?></th>
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
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Detail Stock Transfer")): ?>
                                 <a class="dropdown-item" href="<?php echo e(route('transfer.detail', $d->id)); ?>">
                                     <i class="fas fa-eye"></i> <?php echo e(__('general.detail')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Status Stock Transfer")): ?>
                                 <?php if($d->status != 'complete'): ?>
                                 <a class="dropdown-item po-edit" href="javascript:void(0)" id="<?php echo e($d->id); ?>" onclick="getstatusmodal(this.id)">
                                     <i class="fas fa-check-circle"></i> <?php echo e(__('general.change_status')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <?php endif; ?>
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Print Stock Transfer")): ?>
                                 <a target="_blank" class="dropdown-item" href="<?php echo e(route('transfer.print', $d->id)); ?>">
                                     <i class="fas fa-print"></i> <?php echo e(__('general.print')); ?>

                                 </a>
                                 <?php endif; ?>
                                 <a class="dropdown-item" href="javascript:void(0)">

                                 </a>
                             </div>
                         </div>
                     </div>
                 </td>
                 <td> <?php echo e(my_date($d->created_at)); ?> <input type="hidden" id="idpo" value="<?php echo e($d->id); ?>"></td>
                 <td> <?php echo e($d->ref_no); ?> </td>
                 <td> <?php echo e($d->transfer->fromstore->name ?? ''); ?> </td>
                 <td> <?php echo e($d->transfer->tostore->name ?? ''); ?> </td>
                 <td> <span class=" badge bg-primary text-white"><?php echo e($status[$d->status]); ?></span> </td>
                 <td> <?php echo e(number_format($d->shipping_charges)); ?> </td>
                 <td> <?php echo e(number_format($d->final_total)); ?> </td> 
             </tr>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
     </table>

     <?php echo e($data->links('partials.return_pagination')); ?>

     <a href="javascript:void(0)" class="d-none" id="update_status" data-bs-toggle="modal" data-bs-target="#updatestatus"></a> 
 </div>
<?php /**PATH /var/www/pos/resources/views/admin/stock_transfer/autoload_page.blade.php ENDPATH**/ ?>