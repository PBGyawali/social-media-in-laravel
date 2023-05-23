@include('config')
@include('admin_header')
@include('admin_sidebar',['no_sidebar'=>true])
<style>
#sidebar li a, .dropdown-btn {
color: rgb(239, 237, 243);
    width: 100%;
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
.menu-title {
	color: rgb(239, 237, 243);
	font-size: 15px;
	font-weight: 500;
}
.menu-title > i {
	float: right;
	line-height: 40px;
}
.sidebar-menu li.menu-title a {
	color: #f4f8fa;
	display: inline-block;
	float: right;
	padding: 0;
}
.sidebar-menu li.menu-title a.btn {
	color: #fff;
	display: block;
	float: none;
	font-size: 15px;
	line-height: inherit;
	margin-bottom: 15px;
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



        
        <div class="page-wrapper py-3 my-3">
            <div class="content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">View Message</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="mailview-content">
                                <div class="mailview-header">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="text-ellipsis m-b-10">
                                                <span class="mail-view-title font-weight-bold h4">{{$email->subject}}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mail-view-action">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-light border-1 btn-sm" data-toggle="tooltip" title="Delete"> <i class="fa fa-trash"></i></button>
                                                    <button type="button" class="btn btn-light border-1 btn-sm" data-toggle="tooltip" title="Reply"> <i class="fa fa-reply"></i></button>
                                                    <button type="button" class="btn btn-light border-1 btn-sm" data-toggle="tooltip" title="Forward"> <i class="fa fa-share"></i></button>
                                                </div>
                                                <button type="button" class="btn btn-light border-1 btn-sm" data-toggle="tooltip" title="Print"> <i class="fa fa-print"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sender-info ">
                                        <div>
                                            <span class="sender-img">
                                                <img width="40" alt="" src="{{asset('/images/user_images')}}/user_profile.png" class="rounded-circle">
                                            </span>
                                            <span class="receiver-details float-left">
                                                <div class="sender-name">{{$email->full_name}} [{{$email->email}}]</div>
                                                <span class="receiver-name">
                                                    to <span>me</span>, <span>Richard</span>, <span>Paul</span>
                                                </span>
                                            </span>
                                        </div>
                                        
                                        <div class="mail-sent-time">
                                            <span class="mail-time text-right">{{$email->created_at}}</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                     
                                <div class="mailview-inner">
                                    <p>Hello Richard,</p>
                                    <p>{{$email->message}}.
                                    </p>
                                    
                                    <p>Thanks,
									<br> John Doe</p>
                                </div>
                            </div>
                            <div class="mail-attachments">
                                <p><i class="fa fa-paperclip"></i> 2 Attachments - <a href="#">View all</a> | <a href="#">Download all</a></p>
                                <ul class="attachments clearfix text-center row">
                                    <li class="col-2">
                                        <div class="attach-file py-3 w-auto">
                                            <i class="fa fa-file-pdf bg-white text-danger"></i>
                                        </div>
                                        <div class="attach-info bg-secondary">
											<a href="#" class="attach-filename text-white">daily_meeting.pdf</a>
                                            <div class="attach-fileize text-white"> 842 KB</div>
                                        </div>
                                    </li>
                                    <li class="col-2">
                                        <div class="attach-file w-auto">
                                            <i class="fa fa-file-word text-primary"></i>
                                        </div>
                                        <div class="attach-info bg-secondary">
											<a href="#" class="attach-filename text-white">documentation.docx</a>
                                            <div class="attach-fileize text-white"> 2,305 KB</div>
                                        </div>
                                    </li>  
                                    <li class="col-2">
                                        <div class="attach-file py-3 w-auto">
                                            <img src="{{asset('/images/logo')}}/nothumbnail.png"width="80"alt="Attachment">
                                        </div>
                                        <div class="attach-info bg-secondary">
											<a href="#" class="attach-filename text-white">Vaccination certificate</a>
                                            <div class="attach-fileize text-white"> 842 KB</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mailview-footer">
                                <div class="row">
                                    <div class="col-sm-6 left-action">
                                        <button type="button" class="btn btn-light border-1"><i class="fa fa-reply"></i> Reply</button>
                                        <button type="button" class="btn btn-light border-1"><i class="fa fa-share"></i> Forward</button>
                                    </div>
                                    <div class="col-sm-6 right-action">
                                        <button type="button" class="btn btn-light border-1"><i class="fa fa-print"></i> Print</button>
                                        <button type="button" class="btn btn-light border-1"><i class="fa fa-trash-o"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
@include('layouts.footer_script')