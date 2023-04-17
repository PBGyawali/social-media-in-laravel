<div class="table-responsive ">
    <table class="table table-striped table-bordered " id="table">
        <thead>
            <tr>
                <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_numeric($key)): ?>
                        <th class="<?php echo e($header); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords(str_replace("_", " ", $header))); ?></th>
                    <?php elseif($header==''): ?>
                        <th class="<?php echo e($key); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords(str_replace("_", " ", $key))); ?></th>
                    <?php else: ?>
                        <th class="<?php echo e($key); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords($header)); ?></th>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <th class="action">Action</th>
            </tr>
        </thead>
            <?= $body??'' ?>
    </table>
</div>


<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/table.blade.php ENDPATH**/ ?>