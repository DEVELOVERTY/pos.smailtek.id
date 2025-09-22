<?php if($paginator->hasPages()): ?>
<div class="float start mt-3" style="position: absolute">
    <p> Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> entries <?php echo e($paginator->total()); ?></p>
    
</div>
    <nav class="mt-3 float-end">
        <ul class="pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><?php echo e(__('first')); ?></a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a  class="page-link" id="<?php echo e($paginator->previousPageUrl()); ?>" onclick="movePage(this.id)" href="javascript:void(0)" rel="prev"
                        aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="disabled" aria-disabled="true"><span><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page">
                                <a href="javascript:void(0)" class="page-link"> <?php echo e($page); ?> <span class="sr-only">(current)</span></a>    
                            </li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" onclick="movePage(this.id)" id="<?php echo e($url); ?>" href="javascript:void(0)"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link" id="<?php echo e($paginator->nextPageUrl()); ?>" onclick="movePage(this.id)" href="javascript:void(0)" rel="next"
                        aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&rsaquo;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <a class="page-link" href="#" tabindex="-1"><?php echo e(__('last')); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\tymart\resources\views/partials/product_pagination.blade.php ENDPATH**/ ?>