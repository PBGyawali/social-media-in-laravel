@include('config')
<?php
$website_name=$info->website_name;
$website_logo=$info->website_logo;
?>
@include('login_head_section')
@include('new_message')
<title><?= $website_name; ?></title>
<style>#login_container,#register_container,#reset_password_container,#conditions_container{display:none;}</style>
</head>
@include('main_menu_top')
@include('homepage_container')
@include('login_container')
@include('register_container')
@include('reset_container')
@include('conditions_container')
@include('login_footer')
