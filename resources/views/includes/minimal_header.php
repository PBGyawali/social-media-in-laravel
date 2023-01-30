		<!DOCTYPE html>
		<html>
		<head>
		<html class='no-js' lang="<?= e(str_replace('_', '-', app()->getLocale())); ?>">
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <meta name="csrf-token" content="<?= e(csrf_token()); ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= LOGO_URL?>logo2_4_02_01_21_7052.png " />
        <link rel="stylesheet" href="<?= asset('/css/app.css') ?>">
		<link rel="stylesheet" href="<?= CSS_URL?>bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link rel="stylesheet" href="<?= CSS_URL.'parsley.css'?>" >
		<link rel="stylesheet" href="<?= CSS_URL.'bootstrap_style.css'?>" >
		<link rel="stylesheet" href="<?= CSS_URL?>jquery-confirm.min.css">
        <title><?=isset($page)?ucwords($page):''?></title>
        <script type="text/javascript" src="<?= JS_URL?>history.js"></script>




