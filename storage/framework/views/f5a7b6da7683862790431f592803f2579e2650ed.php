<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="page-title"><?php echo e($page); ?></h6>
                </div>
                <div class="col-md-4">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check("Daftar Printer")): ?>
                    <a class="btn btn-md btn-primary float-end" href="<?php echo e(route('printer.index')); ?>"><i class="fa fa-list"></i> <?php echo e(__('sidebar.printer')); ?></a>
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
                        <h5 class="card-title" style="margin-top: -5px"><?php echo e($page); ?></h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="uPrinter" method="POST" class="form form-horizontal">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('settings.printer_name')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name',$data->name)); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('general.type')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-control" name="type" id="type">
                                                <?php if($data->type == 'offline'): ?>
                                                <option value="offline">Sharing Printer</option>
                                                <option value="online">Rest Api</option>
                                                <?php elseif($data->type == 'online'): ?>
                                                <option value="online">Rest Api</option>
                                                <option value="offline">Sharing Printer</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4 <?php if($data->type != 'online'): ?> d-none <?php endif; ?>" id="label-url">
                                            <label>Url Rest Api</label>
                                        </div>
                                        <div class="col-md-8 form-group <?php if($data->type != 'online'): ?> d-none <?php endif; ?>" id="form-url">
                                            <input type="hidden" name="id" value="<?php echo e($data->id); ?>" id="id">
                                            <input type="url" name="url" class="form-control" value="<?php echo e(old('url',$data->url)); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('settings.char_by_line')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" name="char_per_line" class="form-control" value="<?php echo e(old('char_per_line',$data->char_per_line)); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label><?php echo e(__('settings.ip_address')); ?></label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" name="ip_address" class="form-control" value="<?php echo e(old('ip_address',$data->ip_address)); ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                            <button class="btn btn-info me-1 mb-1"><?php echo e(__('settings.update_printer')); ?></button>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/tymart/resources/views/admin/settings/update_printer.blade.php ENDPATH**/ ?>