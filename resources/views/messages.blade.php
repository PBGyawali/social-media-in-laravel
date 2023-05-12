@include('config')
@include('minimal_header')
@include('sidebar');
<?php
$user_id=auth()->id();
?>
<div class="col-sm-12 offset-xs-3 mr-5 px-0">
    <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">
            <div class="container-fluid px-0">
                <div class="col-lg-12 px-0">
                    <div class="d-flex flex-column" >
                        <h1 class="alert-primary text-center ">Your All Messages</h1>
                    </div>
                </div>
                <?php if (isset($messages) &&!$messages->isEmpty()): ?>
                    <?php foreach ($messages as $key => $chat): ?>
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
</div>
<?= (isset($messages)&&!$messages->isEmpty())?$messages->links():'' ?>
@include('minimal_footer')
<input type="hidden" name="" id="ajaxurl" value="<?= route('user.messages')?>">
<script type="text/javascript" src="{{JS_URL.'notification.js'}}"></script>
@include('footer')
@include('footer_script')
