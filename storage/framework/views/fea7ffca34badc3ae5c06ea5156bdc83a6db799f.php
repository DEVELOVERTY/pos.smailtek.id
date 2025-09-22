<?php $__env->startSection('content'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Variasi Produk")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('variant.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.v_product')); ?></a>
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
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('variant.store', 'update')); ?>" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('produk.variant_type')); ?>*</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$data->name)); ?>" id="name" required placeholder="<?php echo e(__('produk.variant_type')); ?> ">
                                        </div>

                                        <div class="divider mt-2 mb-0">
                                            <div class="divider-text"><?php echo e(__('produk.variant_content')); ?></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('produk.variant_name')); ?></th>
                                                        <th width="110px"><span class="fa fa-cogs"></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hasil">
                                                    <?php
                                                    $no = 1;
                                                    ?>
                                                    <?php $__currentLoopData = $data->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-10 form-group">
                                                                <input type="hidden" name="value_id[]" value="<?php echo e($value->id); ?>">
                                                                <input type="text" class="form-control" name="value_name[]" id="name" value="<?php echo e($value->name); ?>" required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-2">
                                                                <?php if($no++ == 1): ?>
                                                                <button type="button" class="btn btn-sm btn-success" id="add"><i class="fas fa-plus-circle"></i></button>
                                                                <?php else: ?>
                                                                <button type="button" class="btn btn-sm btn-danger " id="<?php echo e($value->id); ?>" onclick="deleteValue(this.id)"><i class="fas fa-minus-circle"></i></button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="variant0"></tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="send" class="btn btn-primary me-1 mb-1"><?php echo e(__('general.update')); ?></button>
                                        </div>
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

<?php $__env->startSection('scripts'); ?>
<script>
    window.onload = function() {
        $('#add').click(function() {
            var cloning = `<tr class="variant">
                    <td>
                        <div class="col-md-10 form-group">
                            <input type="hidden" name="value_id[]" >
                            <input type="text" class="form-control" name="value_name[]" id="name"  required>
                        </div>
                    </td>
                   
                    <td>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger"><i  class="fas fa-minus-circle"></i></button>
                        </div>    
                    </td>
                </tr>`;
            $(".variant0").after(cloning).prev();
        });



        $("body").on("click", ".btn-danger", function() {
            console.log($(this).parents(".variant").remove());
            $(this).parents(".variant").remove();
        });
    }

    var url = document.location.origin;
    var success = $("#success").val();

    function deleteValue(identity) {
        $.post(url + domainpath + "/pos-admin/product/variant/variant-value-delete/" + identity, {
                id: identity,
                _token: token,
            })
            .done(function() {
                toastr.success(success, {
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    positionClass: "toast-top-right",
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "100",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1,
                });

                var ini = $("#" + identity).parents('.variant');
                ini.remove();
            });
        event.preventDefault();
    }
</script>
<script>

</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pos/resources/views/admin/variant/update.blade.php ENDPATH**/ ?>