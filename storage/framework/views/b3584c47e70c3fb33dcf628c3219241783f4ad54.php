
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Tambah Produk")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('product.create')); ?>"><i class="fa fa-plus"></i> <?php echo e(__('sidebar.add_product')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\ValidationComponent::class, []); ?>
<?php $component->withName('admin.validation-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card ">
                        <div class="card-header header-modal">
                            <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body" id="product-content">
                                

                                <div class="table-responsive">
                                    <div class="float-end mb-5">
                                        <form method="get" class="row">
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <select class="form-control" id="unit">
                                                        <option value=""><?php echo e(__('produk.choose_unit')); ?></option>
                                                        <?php $__currentLoopData = $unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($u->id); ?>" <?php if(isset($_GET['unit'])): ?> <?php if($u->id==$_GET['unit']): ?> selected <?php endif; ?>
                                                            <?php endif; ?>><?php echo e($u->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <select class="form-control" id="brand">
                                                        <option value=""><?php echo e(__('produk.choose_brand')); ?></option>
                                                        <?php $__currentLoopData = $brand; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($b->id); ?>" <?php if(isset($_GET['brand'])): ?> <?php if($b->id==$_GET['brand']): ?> selected <?php endif; ?>
                                                            <?php endif; ?>><?php echo e($b->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="name" placeholder="<?php echo e(__('produk.name')); ?>" value="<?php if(isset($_GET['name'])): ?> <?php echo e($_GET['name']); ?> <?php endif; ?>">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" onclick="searchProduct()"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <table class="table table-striped">
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
                                                <th><?php echo e(__('general.action')); ?></th>
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
                                                    <img src="<?php echo e(asset($d->image)); ?>" style="width: 50px; border-radius: 10%">
                                                </td>
                                                <td> <?php echo e($d->name); ?> </td>
                                                <td> <?php echo e($d->category->name ?? ''); ?> </td>
                                                <td> <?php echo e($d->price_sell_range); ?> </td>
                                                <td> <?php echo e($d->price_purchase_range); ?> </td>
                                                <td> <?php echo e($d->unit->name ?? ''); ?> </td>
                                                <td> <?php echo e($d->brand->name ?? ''); ?> </td>
                                                <td> <?php echo e($d->stock_total); ?> </td>
                                                <td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Update Produk")): ?>
                                                    <a href="<?php echo e(route('product.update', $d->id)); ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="<?php echo e(route('product.opening', $d->id)); ?>" class="btn btn-sm btn-success"><i class="fa fa-cubes"></i> <?php echo e(__('produk.open_stock')); ?></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Hapus Produk")): ?>
                                                    <a href="<?php echo e(route('product.delete', $d->id)); ?>" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                    <?php echo e($data->links('partials.product_pagination')); ?>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

    </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/datatables/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendors/datatables/datatables.js')); ?>"></script>
    <script>
        function movePage(url) {
            $("#product-content").html("");
            $.ajax({
                url: url,
                dataType: "html",
                success: function(result) {
                    $('#product-content').html(result);
                }
            });
        }
        var name = null;
        var brand = null;
        var unit = null;
        var supplier = null;

        function searchProduct() {
            var name = $("#name").val();
            var brand = $("#brand").val();
            var unit = $("#unit").val();
            var supplier = $("#supplier").val();
            console.log(supplier);
            $("#product-content").html("");
            $.ajax({
                url: domainpath + '/pos-admin/product?unit=' + unit + '&supplier=' + supplier + '&brand=' + brand + '&name=' + name + '',
                dataType: "html",
                success: function(result) {
                    $('#product-content').html(result);
                }
            });
        }
    </script>
    <?php $__env->stopSection(); ?>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/product/index.blade.php ENDPATH**/ ?>