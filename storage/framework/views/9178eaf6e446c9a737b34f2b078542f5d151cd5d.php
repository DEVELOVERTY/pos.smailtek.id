<div class="col-xl-7 col-md-7 col-sm-12">
    <div class="row" style="height:18vh; overflow: hidden; " id="">

        <div class="cat-slider border-bottom">
            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="cat-item px-1 py-3">
                <a class="card text-center" style="box-shadow: 0px 1px 1px #000;" id="<?php echo e($c->id); ?>" href="javascript:void(0)" onclick="bycategory(this.id)">
                    <img src="<?php echo e(asset($c->image)); ?>"   class="img-fluid mb-1 ">
                    <p class="m-0 "><?php echo e($c->name); ?></p>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
    <div class="row" style="height:75vh; overflow: auto; " id="productData">

        

    </div>
</div><?php /**PATH C:\laragon\www\tymart\resources\views/components/pos/product-component.blade.php ENDPATH**/ ?>