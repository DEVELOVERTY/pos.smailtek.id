<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/datatables.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Tambah Kategori')): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('category.create')); ?>"><i class="fa fa-plus"></i> <?php echo e(__('sidebar.add_category')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Admin\ValidationComponent::class, []); ?>
<?php $component->withName('admin.validation-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>

        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- COUNTRY  DATA -->
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th style="width:70px;text-align: center;"><span class="fa fa-image"></span></th>
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th><?php echo e(__('category.category_name')); ?></th>
                                            <th><?php echo e(__('category.total_product')); ?></th>
                                            <th><?php echo e(__('category.total_subcategory')); ?></th>
                                            <th width="110px"><span class="fa fa-cogs"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="data-product">
                                            <td style="width:70px;">
                                                <a href="javascript:void(0)" data-lity="">
                                                    <img width="50px" src="<?php echo e(asset($c->image)); ?>">
                                                </a>
                                            </td>
                                            <td><?php echo e($c->id); ?></td>
                                            <td><?php echo e($c->kd_category); ?></td>
                                            <td>
                                                <?php echo e($c->name); ?>

                                            </td>
                                            <td class="stock-amount" style="color: #555; width: 15%; font-weight: normal;">
                                                <a class="btn btn-sm btn-primary" href="javascript:void(0)">
                                                    <i class="fa fa-cubes"></i> <?php echo e(count($c->product)); ?>

                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?php if(Auth()->user()->can(" Daftar Subkategori")): ?><?php echo e(route('subcategory.byCat',$c->id)); ?><?php else: ?> # <?php endif; ?>" class="btn btn-sm btn-primary"><i class="fa fa-cube"></i> <?php echo e(count($c->children)); ?></a>
                                            </td>
                                            <td>
                                                <?php if(Auth()->user()->can("Update Kategori")): ?>
                                                <a href="<?php echo e(route('category.update',$c->id)); ?>" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if(Auth()->user()->can("Hapus Kategori")): ?>
                                                <a href="<?php echo e(route('category.delete',$c->id)); ?>" class="btn btn-sm btn-danger deletebutton"><i class="fa fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
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
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/category/index.blade.php ENDPATH**/ ?>