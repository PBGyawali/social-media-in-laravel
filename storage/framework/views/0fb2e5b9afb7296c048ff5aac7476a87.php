<span class="text-center position-absolute w-100"id="message" style="z-index:50">
    <?php
        $usermessages = array('message','error'); ?>
        <?php $__currentLoopData = $usermessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(session()->has($key)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" id="alert">
                        <?php echo session($key); ?>

                        <button type="button" class="close" onclick="hide()">&times;</button>
                    </div>
             <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($errors->any()): ?>
            <div>
                <div class="alert alert-danger" role="alert" id="alert">
                        <button type="button" class="close" onclick="hide()">&times;</button>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>Error <?php echo e($loop->iteration); ?>. <?php echo e($error); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
</span>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/message.blade.php ENDPATH**/ ?>