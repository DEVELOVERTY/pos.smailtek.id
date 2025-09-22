
<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Role")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('role.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.role')); ?></a>
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
                <div class="card header-border">
                    <div class="card-header header-warning">
                        <h5 class="card-title text-white" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('role.store', 'update')); ?>" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('user.role_name')); ?> *</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="hidden" name="id" value="<?php echo e($role->id); ?>" id="role_id">
                                            <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name',$role->name)); ?>" required>
                                        </div>

                                        <div class="divider mt-2 mb-0">
                                            <div class="divider-text"><?php echo e(__('sidebar.role')); ?></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(__('user.permission_name')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $used; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="permission_change">
                                                        <td>
                                                            <div class="form-check">
                                                                <div class="custom-control custom-checkbox">
                                                                    <?php
                                                                    if($p['used'] == 'yes') {
                                                                    $check = 'checked id="permission_id"';
                                                                    } else {
                                                                    $check = '';
                                                                    }
                                                                    ?>
                                                                    <input type="hidden" value="<?php echo e($p['id']); ?>" id="id_permission">
                                                                    <input type="checkbox" class="form-check-input form-check-primary" <?= $check; ?> name="permission_id[]" value="<?php echo e($p['id']); ?>">
                                                                    <label class="form-check-label" for="permission_id"><?php echo e($p['name']); ?></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button type="submit" id="send" class="btn btn-info me-1 mb-1"><?php echo e(__('save')); ?></button>
                                            <button type="reset" class="btn btn-secondary me-1 mb-1">Reset</button>
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
    $(".permission_change").on("click", "#permission_id", function() {
        permission = $(this).closest(".permission_change");
        var id = permission.find("#id_permission").val()
        var role = $("#role_id").val()
        $.ajax({
            url: domain + domainpath + "/pos-admin/user-manager/role-permission-delete/" + id + "/" + role,
            type: "GET",
            data: "",
            success: function(data, json, errorThrown) {
                var dataContent = "";
                var buttonContent = "";
                $.each(data.variant, function(index, value) {
                    console.log("Delete Success");
                });
            },

            cache: false,
            contentType: false,
            processData: false,
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/admin/usermanager/update_role.blade.php ENDPATH**/ ?>