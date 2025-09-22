
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/choices.js/choices.min.css')); ?>" />
<link href="<?php echo e(asset('assets/vendors/summernote/summernote.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Produk")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('product.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.product')); ?></a>
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
            <form action="<?php echo e(route('product.store','create')); ?>" method="POST" enctype="multipart/form-data" class="col-md-12 col-12">
                <?php echo csrf_field(); ?>
                <div class="card ">
                    <div class="card-header header-modal">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.name')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.code')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="<?php echo e(old('sku_product')); ?>" id="product_sku" name="sku_product">
                                                <button class="btn btn-info" type="button" id="get_sku"><i class="fas fa-random"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.category')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="category" id="category">
                                                <option value=""><?php echo e(__('category.choose_category')); ?></option>
                                                <?php $__currentLoopData = $data['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($c->id); ?>" <?php if($c->id == old('category')): ?> selected <?php endif; ?>><?php echo e($c->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('category.subcategory')); ?> ( <?php echo e(__('general.optional')); ?> ) </label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="subcategory" id="subcategory">
                                                <option value=""><?php echo e(__('category.choose_subcategory')); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.brand')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="brand_id" id="brand_id">
                                                <option value=""><?php echo e(__('produk.choose_brand')); ?></option>
                                                <?php $__currentLoopData = $data['brand']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($b->id); ?>" <?php if($b->id == old('brand_id')): ?> selected <?php endif; ?>><?php echo e($b->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.unit')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="unit_id" id="unit_id">
                                                <option value=""><?php echo e(__('produk.choose_unit')); ?></option>
                                                <?php $__currentLoopData = $data['unit']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($u->id); ?>" <?php if($u->id == old('unit_id')): ?> selected <?php endif; ?>><?php echo e($u->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.barcode_type')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="barcode_type" id="barcode_type">
                                                <?php $__currentLoopData = $data['barcode']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $br => $barcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($br); ?>" <?php if($br==old('barcode_type')): ?> selected <?php endif; ?>><?php echo e($barcode); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.min_qty')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="alert_quantity" value="<?php echo e(old('alert_quantity', 0)); ?>" id="alert_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.weight')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="weight" value="<?php echo e(old('weight', 0)); ?>" id="weight">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 1 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field1" value="<?php echo e(old('custom_field1')); ?>" id="custom_field1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 2 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field2" value="<?php echo e(old('custom_field2')); ?>" id="custom_field2">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 3 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field3" value="<?php echo e(old('custom_field3')); ?>" id="custom_field3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 4 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field4" value="<?php echo e(old('custom_field4')); ?>" id="custom_field4">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.detail')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea id="summernote" style="height: 350px" name="description"><?php echo e(old('description')); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.upload_image')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="image" name="image" data-default-file="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card blue-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.product_type')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="type" id="type" required>
                                                <option value=""><?php echo e(__('produk.choose_type')); ?></option>
                                                <option value="single">Single</option>
                                                <option value="variable">Variable</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="hasil"></div>

                                    <div class="row d-none" id="single">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('general.barcode_code')); ?></th>
                                                        <th><?php echo e(__('general.purchase_price')); ?></th>
                                                        <th><?php echo e(__('general.margin')); ?> (%)</th>
                                                        <th><?php echo e(__('general.sell_price')); ?></th>
                                                        <th><?php echo e(__('general.image')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="single_product">
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="sku_" id="sku_">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="p_price" id="p_price">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="number" class="form-control" name="mrg" id="margin">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="s_price" id="s_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="file" class="form-control" name="img" id="image">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row d-none" id="variable">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                        <th width="10%"><?php echo e(__('sidebar.v_product')); ?></th>
                                                        <th><?php echo e(__('produk.variant_content')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-select" name="variation" id="variation">
                                                                <option value="0"><?php echo e(__('produk.choose_variant')); ?> </option>
                                                                <?php $__currentLoopData = $data['variant']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($v->id); ?>">
                                                                    <?php echo e($v->name); ?>

                                                                </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table table" id="table-1">
                                                                    <thead>
                                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                                            <td><?php echo e(__('produk.variant_name')); ?></td>
                                                                            <th><?php echo e(__('general.barcode_code')); ?></th>
                                                                            <td><?php echo e(__('general.purchase_price')); ?></td>
                                                                            <td><?php echo e(__('general.margin')); ?> (%)</td>
                                                                            <td><?php echo e(__('general.sell_price')); ?></td>
                                                                            <td><?php echo e(__('general.image')); ?></td>
                                                                            <td><i class="fa fa-cogs"></i></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="defaulth">
                                                                        <tr class="variant-0">

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="hidden" name="variation_id[]">
                                                                                    <input type="hidden" name="value_id[]">
                                                                                    <input type="text" class="form-control" name="value[]" value="" id="value">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="sku[]" id="sku">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="purchase_price[]" id="purchase_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="number" class="form-control" name="margin[]" id="margin">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="selling_price[]" id="selling_price">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="file" class="form-control" name="im[]" id="image">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <button type="button" class="btn btn-sm btn-success text-white" onclick="add_variant()"><i class="fas fa-plus-circle"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="variant-001"></tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn btn-primary me-1 mb-1"><?php echo e(__('general.add')); ?></button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1"><?php echo e(__('general.reset')); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/summernote/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/choices.js/choices.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/create_produk.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tymart\resources\views/admin/product/create.blade.php ENDPATH**/ ?>