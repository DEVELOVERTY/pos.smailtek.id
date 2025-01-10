
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/vendors/dropify/css/dropify.min.css')); ?>">
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Daftar Produk')): ?>
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

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Cara Import Data Produk</h4>
                        <p class="card-title-desc">Berikut penjelasan untuk mengimport produk secara masaal di mdhpos</p>


                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#documentasiImport" aria-expanded="true" aria-controls="documentasiImport">
                                        Documentasi Import
                                    </button>
                                </h2>
                                <div id="documentasiImport" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Pastikan bahwa format file yang diimport berbentuk <b><small>.xlsx</small></b>, kami sarankan untuk mengimport produk beserta dengan variant produk.
                                        Kamu dapat mengimport produk disheet pertama, dan variant di sheet kedua dengan mengikuti format yang telah ditentukam sebagai berikut
                                        <hr>
                                        <h5 class="mb-4">Format Sheet 1 ( Untuk Import Produk)</h5>
                                        <table class="table" style="background-color: #00b050;">
                                            <tr class="text-white">
                                                <th>ID</th>
                                                <th>PRODUCT NAME</th>
                                                <th>SKU</th>
                                                <th>BARCODE TYPE</th>
                                                <th>CATEGORY ID</th>
                                                <th>BRAND ID</th>
                                                <th>UNIT ID</th>
                                                <th>ALERT QTY</th>
                                                <th>PRODUCT TYPE</th>
                                            </tr>
                                        </table>
                                        <h5 class="mb-4 mt-4">Format Sheet 2 ( Untuk Import Variant)</h5>
                                        <table class="table" style="background-color: #00b050;">
                                            <tr class="text-white">
                                                <th>ID</th>
                                                <th>PRODUCT ID</th>
                                                <th>SKU</th>
                                                <th>NAME</th>
                                                <th>PURCHASE PRICE</th>
                                                <th>SELLING PRICE</th> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12">
                <div class="card ">
                    <div class="card-header header-modal ">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo e(asset('assets/import_product.xlsx')); ?>" target="_blank" class="btn btn-sm btn-success float-end" style="margin-top: -9px; border: 2px solid white; margin-top: -6px"><i class="fas fa-download"></i> Download Sample Import </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('product.import_store')); ?>" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">

                                    <div class="row mb-3">
                                        <div class="col-md-12 form-group">
                                            <label>Upload File, (xlsx)</label>
                                            <input class="dropify" type="file" id="file" name="file" data-default-file="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button class="btn btn-info me-1 mb-1">Import Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/vendors/dropify/js/dropify.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        $('.dropify').dropify();
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\tymart\resources\views/admin/product/import.blade.php ENDPATH**/ ?>