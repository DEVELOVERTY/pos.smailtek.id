
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
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9)): ?>
<?php $component = $__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9; ?>
<?php unset($__componentOriginal98007b0be489209fe44d1d9425e1135b362e0ea9); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

        <div class="row match-height">
            <form method="POST" id="cProduct" enctype="multipart/form-data" class="col-md-12 col-12">
                <?php echo csrf_field(); ?>
                <div class="card ">
                    <div class="card-header header-warning">
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
                                            <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$product->name)); ?>" id="name" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.code')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" value="<?php echo e(old('sku_product',$product->sku)); ?>" id="product_sku" name="sku_product" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.category')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="category" id="category" required>
                                                <option value=""><?php echo e(__('category.choose_category')); ?> </option>
                                                <?php $__currentLoopData = $data['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($c->id == $product->category_id): ?>
                                                <?php
                                                $subcategory = 0;
                                                ?>
                                                <option value="<?php echo e($c->id); ?>" <?php if($c->id == old('category',$product->category_id)): ?> selected <?php endif; ?>><?php echo e($c->name); ?></option>
                                                <?php else: ?>
                                                <?php
                                                $subcategory = 1;
                                                ?>
                                                <option value="<?php echo e($c->id); ?>" <?php if($c->id == old('category',$product->category->parent->id ?? '')): ?> selected <?php endif; ?>><?php echo e($c->name); ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('category.subcategory')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" name="subcategory" id="subcategory">
                                                <?php if($subcategory == 1): ?>
                                                <option value=""><?php echo e(__('category.choose_subcategory')); ?> </option>
                                                <?php else: ?>
                                                <option value="<?php echo e($product->category->id ?? ''); ?>"><?php echo e($product->category->name ?? ''); ?> </option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('sidebar.brand')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="choices form-select" name="brand_id" id="brand_id" required>
                                                <option value=""><?php echo e(__('produk.choose_brand')); ?></option>
                                                <?php $__currentLoopData = $data['brand']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($b->id); ?>" <?php if($b->id == old('brand_id',$product->brand_id ?? '')): ?> selected <?php endif; ?>><?php echo e($b->name); ?></option>
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
                                                <option value="<?php echo e($u->id); ?>" <?php if($u->id == old('unit_id',$product->unit_id)): ?> selected <?php endif; ?>><?php echo e($u->name); ?></option>
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
                                                <option value="<?php echo e($br); ?>" <?php if($br==old('barcode_type',$product->barcode_type)): ?> selected <?php endif; ?>><?php echo e($barcode); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.min_qty')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="alert_quantity" value="<?php echo e(old('alert_quantity', $product->alert_quantity ?? 0)); ?>" id="alert_quantity" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.weight')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" class="form-control" name="weight" value="<?php echo e(old('weight', $product->weight ?? 0)); ?>" id="weight">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 1 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field1" value="<?php echo e(old('custom_field1',$product->custom_field1)); ?>" id="custom_field1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 2 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field2" value="<?php echo e(old('custom_field2',$product->custom_field2)); ?>" id="custom_field2">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 3 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field3" value="<?php echo e(old('custom_field3',$product->custom_field3)); ?>" id="custom_field3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.custom_field')); ?> 4 ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="custom_field4" value="<?php echo e(old('custom_field4',$product->custom_field4)); ?>" id="custom_field4">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.detail')); ?> ( <?php echo e(__('general.optional')); ?> )</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <textarea id="summernote" style="height: 350px" name="description"><?php echo e(old('detail',$product->description)); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.upload_image')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input class="dropify" type="file" id="image" name="image" data-default-file="<?php echo e(asset($product->image)); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card warning-card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('product')); ?> <?php echo e(__('type')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="type" value="<?php echo e($product->type); ?>" required readonly>
                                        </div>
                                    </div>
                                    <?php if($product->type == 'single'): ?>

                                    <div class="row" id="single">
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
                                                <tbody class="single_product">
                                                    <?php $__currentLoopData = $product->variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="hidden" name="variant_id" value="<?php echo e($variant->id); ?>">
                                                                <input type="text" class="form-control" name="sku_" value="<?php echo e($variant->sku); ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="p_price" value="<?php echo e(number_format($variant->purchase_price)); ?>" id="p_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="number" class="form-control" name="mrg" value="<?php echo e($variant->margin); ?>" id="margin">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="text" class="form-control" name="s_price" value="<?php echo e(number_format($variant->selling_price)); ?>" id="s_price">
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="file" class="form-control" name="img" id="image">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php elseif($product->type == 'variable'): ?>
                                    <div class="row" id="variable">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-1">
                                                <thead>
                                                    <tr style="background-color: #5cb85c; border: 1px solid white" class="text-white">
                                                        <th><?php echo e(__('produk.variant_content')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="table-responsive">
                                                                <table class="table table" id="table-1">
                                                                    <thead>
                                                                        <tr style="background-color: #3c8dbc; border: 1px solid white" class="text-white">
                                                                            <td><?php echo e(__('general.barcode_code')); ?></td>
                                                                            <td><?php echo e(__('produk.variant_name')); ?></td>
                                                                            <td><?php echo e(__('general.purchase_price')); ?></td>
                                                                            <td><?php echo e(__('general.margin')); ?> (%)</td>
                                                                            <td><?php echo e(__('general.sell_price')); ?></td>
                                                                            <td><?php echo e(__('general.image')); ?></td>
                                                                            <td><i class="fa fa-cogs"></i></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="defaulth">
                                                                        <?php
                                                                        $no = 1;
                                                                        $num = 0;
                                                                        ?>
                                                                        <?php $__currentLoopData = $product->variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr class="variant variant-<?php if($num++ == 0): ?>0 <?php else: ?><?php echo e($variant->id); ?> <?php endif; ?>">
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" value="<?php echo e($variant->sku); ?>" name="sku[]">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="hidden" name="variation_id[]" value="<?php echo e($variant->id); ?>">
                                                                                    <input type="hidden" name="value_id[]" value="<?php echo e($variant->variation_value_id); ?>">
                                                                                    <input type="text" class="form-control" name="value[]" value="<?php echo e($variant->name); ?>" readonly id="value">
                                                                                </div>
                                                                            </td>


                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="purchase_price[]" value="<?php echo e(number_format($variant->purchase_price)); ?>" id="purchase_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="number" class="form-control" name="margin[]" value="<?php echo e($variant->margin); ?>" id="margin">
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="text" class="form-control" name="selling_price[]" value="<?php echo e(number_format($variant->selling_price)); ?>" id="selling_price">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <div class="col-md-10 form-group">
                                                                                    <input type="file" class="form-control" name="im[]" id="image">
                                                                                </div>
                                                                            </td>

                                                                            <td>
                                                                                <?php if($no++ == 1): ?>
                                                                                <button type="button" class="btn btn-sm btn-success text-white" onclick="add_variant()"><i class="fas fa-plus-circle"></i></button>
                                                                                <?php else: ?>
                                                                                <button type="button" class="btn btn-sm btn-danger " id="<?php echo e($variant->id); ?>" onclick="delete_variant(this.id)"><i class="fas fa-minus-circle"></i></button>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php endif; ?>



                                </div>

                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <button class="btn btn-primary me-1 mb-1"><?php echo e(__('general.update')); ?></button>
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
<script src="<?php echo e(asset('js/update_product.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/product/update.blade.php ENDPATH**/ ?>