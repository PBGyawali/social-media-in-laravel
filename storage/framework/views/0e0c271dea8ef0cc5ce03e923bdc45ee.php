<?php echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('admin_sidebar',['no_sidebar'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    #sidebar li a, .dropdown-btn {
    color: rgb(239, 237, 243);
        width: 100%;
    }
        /*-----------------
        29. Inbox
    -----------------------*/
    
    .table-inbox input[type="radio"],
    .table-inbox input[type="checkbox"] {
        cursor: pointer;
    }
    .mail-list {
        list-style: none;
        padding: 0;
    }
    .mail-list > li > a {
        color: #333;
        display: block;
        padding: 10px;
    }
    .mail-list > li.active > a {
        color: #eef2f5;
        font-weight: bold;
    }
    .unread .name,
    .unread .subject,
    .unread .mail-date {
        color: #000;
        font-weight: 600;
    }
    .table-inbox .fa-star {
        color: #ffd200;
    }
    .table-inbox .starred.fa-star {
        color: #ffd200;
    }
    .table.table-inbox > tbody > tr > td,
    .table.table-inbox > tbody > tr > th,
    .table.table-inbox > tfoot > tr > td,
    .table.table-inbox > tfoot > tr > th,
    .table.table-inbox > thead > tr > td,
    .table.table-inbox > thead > tr > th {
        border-bottom: 1px solid #f2f2f2;
        border-top: 0;
    }
    .table-inbox {
        font-size: 14px;
        margin-bottom: 0;
    }
    .note-editor.note-frame {
        border: 1px solid #ccc;
        box-shadow: inherit;
    }
    .note-editor.note-frame .note-statusbar {
        background-color: #fff;
    }
    .note-editor.note-frame.fullscreen {
        top: 60px;
    }
    .mail-title {
        font-weight: bold;
        text-transform: uppercase;
    }
    .form-control.search-message {
        border-radius: 4px;
        margin-left: 5px;
        width: 180px;
        padding: 0.375rem 0.75rem;
        min-height: 35px;
        margin-bottom: 5px;
    }
    .table-inbox tr {
        cursor: pointer;
    }
    table.table-inbox tbody tr.checked {
        background-color: #ffffcc;
    }
    .mail-label {
        margin-right: 5px;
    }
    
    /*-----------------
        30. Mail View
    -----------------------*/
    
    .attachments {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .attachments li {
        border: 1px solid #eee;
        float: left;
        margin-bottom: 10px;
        margin-right: 10px;
        width: 200px;
    }
    .attach-file {
        color: #777;
        font-size: 70px;
        padding: 10px;
        text-align: center;
        min-height: 153px;
    }
    .attach-file > i {
        line-height: 133px;
    }
    .attach-info {
        background-color: #f4f4f4;
        padding: 10px;
    }
    .attach-filename {
        color: #777;
        font-weight: bold;
    }
    .attach-filesize {
        color: #999;
        font-size: 12px;
    }
    .attach-file img {
        height: auto;
        max-width: 100%;
    }
    .mailview-header {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 15px;
    }
    .mailview-footer {
        border-top: 1px solid #ddd;
        margin-top: 20px;
        padding-top: 15px;
    }
    .mailview-footer .btn-white {
        min-width: 102px;
    }
    .sender-img {
        float: left;
        margin-right: 10px;
        width: 40px;
    }
    .sender-name {
        display: block;
    }
    .receiver-name {
        color: #777;
    }
    .right-action {
        text-align: right;
    }
    .mail-view-title {
        font-weight: 500;
        font-size: 24px;
        margin: 0;
    }
    .mail-view-action {
        float: right;
    }
    .mail-sent-time {
        float: right;
    }
    
    /*-----------------
        6. Sidebar
    -----------------------*/
    
    .sidebar {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
        top: 50px;
        width: 230px;
        z-index: 9;
        background-color: #131111;
        bottom: 0;
        margin-top: 0px;
        position: fixed;
        left: 0;
        transition: all 0.2s ease-in-out;
    }
    .sidebar.opened {
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }
    .sidebar-inner {
        height: 100%;
        transition: all 0.2s ease-in-out 0s;
    }
    .sidebar-menu ul {
        font-size: 14px;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .sidebar-menu li a {
        color: #d12020;
        display: block;
        font-size: 15px;
        height: auto;
        padding: 0 20px;
    }
    .sidebar-menu li a:hover {
        color: #eff7fc;
    }
    .sidebar-menu li.active a {
        color: #eef5f8;
        background-color: #1fcc0f;
    }
  
    .sidebar-menu ul ul a.active {
        color: #009efb;
        text-decoration: underline;
    }
    .mobile-user-menu {
        color: #fff;
        display: none;
        font-size: 24px;
        height: 50px;
        line-height: 50px;
        padding: 0 20px;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
        width: 50px;
        z-index: 10;
    }
    .mobile-user-menu > a {
        color: #fff;
        padding: 0;
    }
    .mobile-user-menu > a:hover {
        color: #fff;
    }
    .mobile-user-menu > .dropdown-menu > a {
        line-height: 23px;
    }
    .profile-rightbar {
        display: none !important;
        color: #009efb;
        font-size: 26px;
        margin-left: 15px;
    }
    .fixed-sidebar-right {
        position: fixed;
        top: 60px;
        right: 0;
        width: 300px;
        margin-right: -300px;
        bottom: 0;
        z-index: 101;
        -webkit-transition: all 0.4s ease;
        -moz-transition: all 0.4s ease;
        transition: all 0.4s ease;
    }
    .mobile_btn {
        display: none;
    }
    .sidebar .sidebar-menu > ul > li > a span {
        transition: all 0.2s ease-in-out 0s;
        display: inline-block;
        margin-left: 10px;
        white-space: nowrap;
    }
    .sidebar .sidebar-menu > ul > li > a span.badge {
        color: #fff;
        margin-left: auto;
    }
    .sidebar-menu ul ul a {
        display: block;
        font-size: 14px;
        padding: 9px 10px 9px 50px;
        position: relative;
    }
    .sidebar-menu ul ul {
        background-color: #f3f3f3;
        display: none;
    }
    .sidebar-menu ul ul ul a {
        padding-left: 70px;
    }
    .sidebar-menu ul ul ul ul a {
        padding-left: 90px;
    }
    .sidebar-menu > ul > li {
        position: relative;
    }
    .sidebar-menu .menu-arrow {
        -webkit-transition: -webkit-transform 0.15s;
        -o-transition: -o-transform 0.15s;
        transition: transform .15s;
        position: absolute;
        right: 15px;
        display: inline-block;
        font-family: 'FontAwesome';
        text-rendering: auto;
        line-height: 40px;
        font-size: 18px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        -webkit-transform: translate(0, 0);
        -ms-transform: translate(0, 0);
        -o-transform: translate(0, 0);
        transform: translate(0, 0);
        line-height: 18px;
        top: 15px;
    }
    .sidebar-menu .menu-arrow:before {
        content: "\f105";
    }
    .sidebar-menu li a.subdrop .menu-arrow {
        -ms-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }
    .sidebar-menu ul ul a .menu-arrow {
        top: 6px;
    }
    .sidebar-menu a {
        transition: unset;
        -moz-transition: unset;
        -o-transition: unset;
        -ms-transition: unset;
        -webkit-transition: unset;
    }
    .sidebar-menu > ul > li > a {
        padding: 12px 20px;
        align-items: center;
        display: flex;
        justify-content: flex-start;
        position: relative;
        transition: all 0.2s ease-in-out 0s;
    }
    .sidebar-menu ul li a i {
        align-items: center;
        display: inline-flex;
        font-size: 18px;
        min-height: 24px;
        line-height: 18px;
        width: 20px;
        transition: all 0.2s ease-in-out 0s;
    }
    .sidebar-menu ul li.menu-title a i {
        font-size: 16px;
        margin-right: 0;
        text-align: right;
        width: auto;
    }
    
    </style>
    
 
        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Compose</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <form action="<?php echo e(route('support')); ?>" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <input type="email" placeholder="To" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" placeholder="Cc" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" placeholder="Bcc" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <textarea rows="4" cols="5" id="body" class="form-control summernote" placeholder="Enter your message here"></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-center compose-btn">
                                        <button type="submit" class="btn btn-primary"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                        <button class="btn btn-success m-l-5" type="button"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
        <?php echo $__env->make('footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php /**PATH D:\Dropbox\UniServerZ\www\media\resources\views/admin/compose.blade.php ENDPATH**/ ?>