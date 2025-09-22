<div class="cat-slider border-bottom">
    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="cat-item px-1 py-3" >
        <a class="d-block text-center" id="<?php echo e($c->id); ?>" href="javascript:void(0)" onclick="bycategory(this.id)">
            <img src="<?php echo e(asset($c->image)); ?>" style="width: 80%; height:70px" class="img-fluid mb-2 shadow">
            <p class="m-0 small"><?php echo e($c->name); ?></p>
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /var/www/pos/resources/views/components/pos-mobile/category-component.blade.php ENDPATH**/ ?>