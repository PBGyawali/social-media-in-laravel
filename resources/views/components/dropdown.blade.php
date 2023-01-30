<li class="dropdown" role="presentation">
    <a data-toggle="dropdown" aria-expanded="false" class="cursor-pointer no-border p-0 m-0 bg-transparent"><span id="current_user"  class="d-none d-md-inline-block text-white"><?= $username?></span> <span id="user_uploaded_image_small" class="mt-0"><img src="<?= $profileimage; ?>" class="img-fluid rounded-circle" width="30" height="30"/></a></span>
            <div class="dropdown-menu dropdown-menu-right shadow animated zoomIn px-2 " role="menu">
                <a class="dropdown-item" role="presentation" href="<?= route($side.'profile')?>"><i class="fas fa-id-badge fa-fw mr-2 text-gray-800"></i>&nbsp;Profile</a>
                <a class="dropdown-item" role="presentation" href="<?= route($side.'password')?>"><i class="fas fa-key fa-fw mr-2 text-gray-800"></i>&nbsp;Password</a>
                <a class="dropdown-item" role="presentation" href="<?= route($side.'settings')?>"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-800"></i>&nbsp;Settings</a>
                <a class="dropdown-item" role="presentation" href="<?= route($side.'activitylog')?>"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-800"></i>&nbsp;Activity log</a>
                <?php if (auth()->user()->is_editor() && $side):?>
                <a class="dropdown-item" role="presentation" href="<?= route('admin.dashboard')?>"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-700"></i>&nbsp;Admin Panel</a>
                <?php endif?>
                <div class="dropdown-divider"></div>
                <form action="<?= route('logout')?>" method="post" class="logout_form">
                        <?= csrf_field(); ?>
                    <button class="dropdown-item logout" role="presentation" type="submit" title="Clicking this button will log you out.">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-800"></i>&nbsp;Logout
                    </button>
                </form>
            </div>
</li>
