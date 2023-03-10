@include('config')
<?php
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
$logged_username=(isset($log_username)&&!empty($log_username))?'for '. $log_username:'';
 ?>
    <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">
            <div class="container-fluid ">
                <div class="col-12 p-0">
                    <div class="d-flex flex-column" >
                        <h1 class="alert-primary text-center ">All Messages <?= $logged_username ?></h1>
                    </div>
                </div>
                <?php if (isset($logged_message) &&!$logged_message->isEmpty()): ?>
                    <?php foreach ($logged_message as $key => $chat): ?>
                        @include('message_body')
                    <?php endforeach ?>
                <?php else: ?>
                <h1>
                    @include('no_messages')
                </h1>
                <?php endif ?>
            </div>
        </div>
    </div>


<input type="hidden" name="" id="ajaxurl" value="<?= route('messages')?>">
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>
<?php include_once(LAYOUTS.'footer.php');?>
