<div class="table-responsive">
    <div class="float-end mb-5">
        <form method="get" class="row">
            <div class="col-3">
                <div class="input-group">
                    <select class="form-control" id="unit">
                        <option value=""><?php echo e(__('produk.choose_unit')); ?></option>
                        <?php $__currentLoopData = $unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($u->id); ?>" <?php if(isset($_GET['unit'])): ?>  <?php if($u->id==$_GET['unit']): ?> selected <?php endif; ?>
                        <?php endif; ?>><?php echo e($u->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group">
                    <select class="form-control" id="brand">
                        <option value=""><?php echo e(__('produk.choose_brand')); ?></option>
                        <?php $__currentLoopData = $brand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($b->id); ?>" <?php if(isset($_GET['brand'])): ?>  <?php if($b->id==$_GET['brand']): ?> selected <?php endif; ?>
                        <?php endif; ?>><?php echo e($b->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="name" placeholder="<?php echo e(__('produk.name')); ?>"
                        value="<?php if(isset($_GET['name'])): ?> <?php echo e($_GET['name']); ?> <?php endif; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="searchProduct()" ><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped" id="tableExport">
        <thead>
            <tr>
                <th class="text-center"> No </th>
                <th><?php echo e(__('general.image')); ?></th>
                <th><?php echo e(__('produk.name')); ?></th>
                <th><?php echo e(__('category.category_name')); ?></th>
                <th><?php echo e(__('general.sell_price')); ?></th>
                <th><?php echo e(__('general.purchase_price')); ?></th>
                <th><?php echo e(__('sidebar.unit')); ?></th>
                <th><?php echo e(__('sidebar.brand')); ?></th>
                <th><?php echo e(__('general.stock')); ?></th>
                <th><?php echo e(__('general.stock')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
            ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($no++); ?> </td>
                    <td>
                        <img src="<?php echo e(asset($d->image)); ?>" style="width: 50px; border-radius:10%">
                    </td>
                    <td> <?php echo e($d->name); ?> </td>
                    <td> <?php echo e($d->category->name ?? ''); ?> </td>
                    <td> <?php echo e($d->price_sell_range); ?> </td>
                    <td> <?php echo e($d->price_purchase_range); ?> </td>
                    <td> <?php echo e($d->unit->name ?? ''); ?> </td>
                    <td> <?php echo e($d->brand->name ?? ''); ?> </td>
                    <td> <?php echo e($d->stock_total); ?>  </td>
                    <td>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Produk")): ?>
                        <a href="<?php echo e(route('product.update', $d->id)); ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="<?php echo e(route('product.opening', $d->id)); ?>" class="btn btn-sm btn-success"><i class="fa fa-cubes"></i> <?php echo e(__('produk.open_stock')); ?></a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Hapus Produk")): ?>
                        <a href="<?php echo e(route('product.delete', $d->id)); ?>"  class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($data->links('partials.product_pagination')); ?>

</div>

<?php /**PATH /var/www/pos/resources/views/admin/product/autoload_page.blade.php ENDPATH**/ ?>