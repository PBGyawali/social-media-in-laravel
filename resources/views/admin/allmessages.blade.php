@include('config')
@include('admin_header')
@include('admin_sidebar')
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
@include('footer_script')
