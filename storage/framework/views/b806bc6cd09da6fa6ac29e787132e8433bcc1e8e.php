<div class="row top" style="margin-bottom: -1px; margin-left:0px; margin-right:0px; background-color: #4882c3;">
    <div class=" table-responsive">
        <table class="table mx-2" style=" margin-bottom:-0px; border: solid #4882c3">
            <tr>
                <th style="width:65%;" class="formsearch">
                    <div class="input-group" style="height: 6vh" id="seacrhform">
                        <input type="text" class="form-control form-pencarian" placeholder="Cari / Scan Produk" id="searchProduct" style="margin-top:0px;">
                        <span class="input-group-text">
                            <i class="fas fa-barcode"></i>
                        </span>
                    </div>
                    <div class="d-none" id="choosecustomer">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <div class="position-relative">
                                        <select class="select2 form-control form-category" name="category" id="category" style="width:100%; ">
                                            <option value="all"><?php echo e(__('pos.all_category')); ?></option>
                                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <optgroup label="<?php echo e($c->name); ?>">
                                                <?php $__currentLoopData = $c->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($sub->id); ?>"><?php echo e($sub->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="input-group">
                                    <select class="select2 form-control form-user" name="customer_id" id="customer_id" style="width:100%; ">
                                        <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="">-Pilih Pelanggan-</option>
                                        <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th class="text-right">
                    <button onclick="swicthcustomer()" class="btn btn-lg btn-light btn-rounded btn-primary float-end swicthcustomer" type="button">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button onclick="swicthsearch()" class="btn btn-lg btn-light btn-rounded btn-primary float-end swicthsearch d-none" type="button">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                </th>

            </tr>
        </table>
    </div>
</div><?php /**PATH /var/www/tymart/resources/views/components/pos/header-component.blade.php ENDPATH**/ ?>