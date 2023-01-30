@include('config')
@include('minimal_header')
@include('new_message')
<?php
$website=$info;
$website_name=$website['website_name'];
$website_logo=$website['website_logo'];
?>
@include('new_message')
<link rel="stylesheet" href="<?=CSS_URL?>outside_login.css">
<title><?= $website_name; ?></title>
</head>
<body>
    @include('main_menu_top')
    <div class="container">
        <div class="header">
            <h2>Verify account</h2>
        </div>
        <form class="verify-form" method="post">
            <?php displaymessage('',$errors);?>
        </form>
    </div>
</body>
</html>
