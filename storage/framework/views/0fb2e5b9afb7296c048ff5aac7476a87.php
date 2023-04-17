<span class="text-center position-absolute w-100"id="message" style="z-index:50" onclick="hide()">
    <?php
        $usermessages = array('message','error'); ?>
        <?php $__currentLoopData = $usermessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(session()->has($key)): ?>
                    <?php echo session($key); ?>

             <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</span>
<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/message.blade.php ENDPATH**/ ?>