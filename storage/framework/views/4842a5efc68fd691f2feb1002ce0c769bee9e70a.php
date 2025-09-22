<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger"> <?php echo e($error); ?></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($message = Session::get('flash')): ?>
    <div class="flash-data" data-flashdata="<?php echo e($message); ?>"></div>
<?php endif; ?>

<?php if($message = Session::get('gagal')): ?>
    <div class="gagal" data-gagal="<?php echo e($message); ?>"></div>
<?php endif; ?>

<?php /**PATH /var/www/pos/resources/views/components/admin/validation-component.blade.php ENDPATH**/ ?>