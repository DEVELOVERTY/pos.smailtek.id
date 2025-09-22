<div class="modal fade" id="categorysortir" tabindex="-1" role="dialog" aria-labelledby="categorysortirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="cCustomer" method="POST" class="modal-content">

            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="exampleModalLabel">Pilih atau Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="feather-x float-right"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="mdhpos-filter">
                    <div class="filter">
                        <div class="filters-body">
                            <div class="col-md-12 form-group mt-3">
                                <label class="form-label mb-1 small">Pilih Customer</label>
                                <div class="input-group">
                                    <select class="select2 form-control form-user" name="customer_id" id="customer_id" style="width:100%; ">
                                        <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <hr style="border: 1px solid black;">
                            <h6 class="p-3">Tambah Customer</h6>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('customer.name')); ?> * </label>
                                <div class="input-group">
                                    <input style="border: 1px solid black;" type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.phone')); ?> </label>
                                <div class="input-group">
                                    <input style="border: 1px solid black;" type="number" name="phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.email')); ?> </label>
                                <div class="input-group">
                                    <input style="border: 1px solid black;" type="email" name="email" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.code')); ?> </label>
                                <div class="input-group">
                                    <input style="border: 1px solid black;" type="text" name="code" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.city')); ?> </label>
                                <div class="input-group">
                                    <input style="border: 1px solid black;" type="text" name="city" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.address')); ?> </label>
                                <div class="input-group">
                                    <textarea style="border: 1px solid black;" class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 form-group mt-1">
                                <label><?php echo e(__('general.detail')); ?> </label>
                                <div class="input-group">
                                    <textarea style="border: 1px solid black;" class="form-control" name="detail" id="detail"></textarea>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-0 border-0 p-3">
                <div class="col-6 m-0 pl-0 pr-1">
                    <button type="button" class="btn border btn-lg btn-block" data-dismiss="modal">Tutup</button>
                </div>
                <div class="col-6 m-0 pl-0 pr-1">
                    <a href="javascript:void(0)" id="saveCustomer" class="btn btn-primary border btn-lg btn-block">Tambah Customer</a>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/pos/resources/views/components/pos-mobile/filter-component.blade.php ENDPATH**/ ?>