<div class="table-responsive">
    <table class="table table-bordered">
        <?php $__currentLoopData = $viewdatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $viewdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <?php if(in_array($key,['Status','Email status','Profile Verification status'])): ?>
            <td><?php echo e(ucwords($key)); ?></td>
            <td><span class="badge badge-<?php echo e($viewdata['class']); ?>"><?php echo e($viewdata['value']); ?></span></td>
            <?php elseif($key=='image'): ?>
            <td><?php echo e(ucwords($key)); ?></td>
            <td><img id="profile_image" src="<?php echo e($viewdata); ?>" class="rounded-circle mb-0 mt-0 img-fluid" width="200" alt="thumbnail">
                </td>
            <?php elseif($key=='remarks'): ?>
            <td><?php echo e(ucwords($key)); ?></td>
            <td><textarea name="remarks" id="remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup"><?php echo e($viewdata); ?></textarea></td>
            <?php else: ?>
            <td><?php echo e(ucwords($key)); ?></td>
            <td><?php echo e(ucwords($viewdata)); ?></td>
            <?php endif; ?>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</div>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/view-modal.blade.php ENDPATH**/ ?>