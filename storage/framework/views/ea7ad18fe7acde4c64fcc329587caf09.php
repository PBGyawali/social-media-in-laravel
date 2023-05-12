
    <table class="table table-striped table-bordered table-hover table-sm " id="<?php echo e($id??'table'); ?>">
        <thead class="thead-dark">
            <tr>
                <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_numeric($key)): ?>
                        <th class="<?php echo e($header); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords(str_replace('_',' ',explode(".",explode(" ",$header)[0])[array_key_last(explode(".",explode(" ",$header)[0]))]))); ?></th>
                    <?php elseif($header==''): ?>
                        <th class="<?php echo e($key); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords(str_replace('_',' ',explode(".",explode(" ",$key)[0])[array_key_last(explode(".",explode(" ",$key)[0]))]))); ?></th>
                    <?php else: ?>
                        <th class="<?php echo e($key); ?> <?php echo e($class??''); ?>"><?php echo e(ucwords(str_replace('_',' ',$header))); ?></th>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(empty($no_action)): ?>
                <th class="action">Action</th>
                <?php endif; ?>

            </tr>
        </thead>
            <?= $body??'' ?>
    </table>


<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/table.blade.php ENDPATH**/ ?>