<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<input type="checkbox"
        class=toggle
        data-column="<?php echo e($key); ?>">  <?php echo e(ucwords(str_replace("_", " ", $column))); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/table-checkbox.blade.php ENDPATH**/ ?>