@include('config')
 @include('minimal_header')
 @include('new_message')
<?php
$website_name=$info->website_name;
$website_logo=$info->website_logo;
?>
<link rel="stylesheet" href="<?= CSS_URL?>outside_login.css">
</head>
<body>
@include('main_menu_top')
@include('reset_container')
</body>
</html>
