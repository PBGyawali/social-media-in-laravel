<div align="text-center">
    <?php if(in_array('view', $buttons)): ?>
    <button type="button" class="btn btn-info btn-sm view" title="View <?php echo e($prefix); ?> data"data-id="<?php echo e($id); ?>">
      <i class="fas fa-eye"></i>
    </button>
    <?php endif; ?>
    <?php if(in_array('update', $buttons)): ?>
    <button type="button" class="btn btn-primary mb-1 btn-sm update" data-target="<?php echo e($target??''); ?>" data-prefix="<?php echo e(ucwords($prefix)); ?>" data-id="<?php echo e($id); ?>"><i class="fas fa-eye"></i></button>
    <?php endif; ?>
    <?php if(in_array('delete', $buttons)): ?>
      <button type="button"  class="btn btn-danger btn-sm border delete"  data-action="delete" title="Delete <?php echo e($prefix); ?> data" data-id="<?php echo e($id); ?>">
        <i class="fas fa-times"></i>
      </button>
    <?php endif; ?>
    <?php if(in_array('edit', $buttons)): ?>
      <?php if(empty($editurl)): ?>
        <button type="button" class="btn btn-secondary btn-sm update" data-prefix="<?php echo e(trim(ucwords($prefix.' '.($extratext??'')))); ?>" title="Edit <?php echo e($prefix); ?> data" data-id="<?php echo e($id); ?>">
          <i class="fas fa-edit"></i>
        </button>
      <?php else: ?>
        <form  action="<?php echo e($editurl); ?>" class="userlistform" target="_blank" method="post" >
          <?php echo e(csrf_field()); ?>

          <input type="hidden" name="id" value="<?php echo e($id); ?>">
        <button type="submit" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button"  data-id="<?php echo e($id); ?>"></button>
        </form>
      <?php endif; ?>
    <?php endif; ?>
    <?php if(isset($reseturl)): ?>
      <button type="button"  class="btn btn-primary btn-sm reset" title="Reset <?php echo e($prefix); ?> password"data-url="<?php echo e($reseturl); ?>" data-id="<?php echo e($id); ?>">
        <i class="fas fa-sync"></i>
      </button>
    <?php endif; ?>
    <?php if(in_array('verify', $buttons)): ?>
      <button type="button"  class="btn btn-success btn-sm verify" data-id="<?php echo e($id); ?>" title="Verify <?php echo e($prefix); ?>">
        <i class="fas fa-check"></i>
      </button>
    <?php endif; ?>
    <?php if(isset($alertsurl)): ?>
    <a  href="<?php echo e($alertsurl); ?>" class="btn btn-success btn-sm" title="Show all <?php echo e($prefix); ?> alerts" target="_blank">
      <i class="fas fa-bell"></i>
    </a>
    <?php endif; ?>
    <?php if(isset($activitylogurl)): ?>
    <a  href="<?php echo e($activitylogurl); ?>" class="btn btn-success btn-sm" title="Show all <?php echo e($prefix); ?> activity" target="_blank">
      <i class="fas fa-list"></i>
    </a>
    <?php endif; ?>

    <?php if(in_array('status', $buttons)): ?>
          <?php if($status =='active'): ?>
            <button type="button" data-prefix="<?php echo e($prefix); ?>" class="btn btn-warning btn-sm  status " title="Disable <?php echo e($prefix); ?>" data-status="inactive" data-id="<?php echo e($id); ?>">
              <i class="fas fa-ban"></i>
            </button>
          <?php else: ?>
            <button type="button" data-prefix="<?php echo e($prefix); ?>" class="btn btn-success btn-sm status " title="Enable <?php echo e($prefix); ?>" data-status="active" data-id="<?php echo e($id); ?>">
              <i class="fas fa-unlock-alt"></i>
            </button>
          <?php endif; ?>
    <?php endif; ?>
</div>

<?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views\components/control-buttons.blade.php ENDPATH**/ ?>