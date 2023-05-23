<!DOCTYPE html>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="<?= e(csrf_token()); ?>">
		<script type="text/javascript" src="<?= JS_URL?>jquery.min.js"></script>
		<script type="text/javascript" src="<?= JS_URL?>datatables.min.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="<?= LOGO_URL?>logo2_4_02_01_21_7052.png " />
		<script type="text/javascript" src="<?= JS_URL?>parsley.min.js"></script>
    <script type="text/javascript" src="<?= JS_URL?>bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="<?= JS_URL?>jquery-confirm.min.js"></script>
    <script type="text/javascript" src="<?= JS_URL?>jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?= JS_URL?>theme.js"></script>
    <!-- styling css -->
    
    <link rel="stylesheet" href="<?= asset('/css/app.css') ?>">
    <link rel="stylesheet" href="<?= CSS_URL?>bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="<?= CSS_URL?>datatables.min.css" >
    <link rel="stylesheet" href="<?= CSS_URL?>parsley.css" >
    <link rel="stylesheet" href="<?= CSS_URL?>jquery-confirm.min.css">
    <link rel="stylesheet" href="<?= CSS_URL?>bootstrap_style.css" >
    <link rel="stylesheet" href="<?= CSS_URL?>animate.css">
    <title><?=$page=='index'?'Dashboard':ucwords($page);?></title>

	</head>
  <body id="page-top">
    
