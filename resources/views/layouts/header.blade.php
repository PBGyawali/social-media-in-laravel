<?php $website=(isset($info)?$info->website_name:'');
		$pagetitle=((isset($page)&& $page=='welcome')?'WELCOME TO':'')
?>
        <!DOCTYPE html>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
		<head>
		<html class='no-js' lang='en'>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
		<script type="text/javascript" src="<?= JS_URL.'jquery.min.js'?>"></script>
		<script type="text/javascript" src="<?= JS_URL.'popper.min.js'?>"></script>
		<script type="text/javascript" src="<?= JS_URL?>jquery-confirm.min.js"></script>
		<link rel="stylesheet" href="<?= CSS_URL?>bootstrap.min.css">
		<link rel="stylesheet" href="<?= CSS_URL?>jquery-confirm.min.css">
		<script type="text/javascript" src="<?= JS_URL?>bootstrap.bundle.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script type="text/javascript" src="<?= JS_URL?>datatables.min.js"></script>
		<script type="text/javascript" src="<?= JS_URL?>dataTables.responsive.min.js"></script>
		<link rel="stylesheet" href="<?= CSS_URL?>datatables.min.css" >
		<link rel="stylesheet" href="<?= CSS_URL.'parsley.css'?>" >
		<script type="text/javascript" src="<?= JS_URL.'parsley.min.js'?>"></script>
		<title><?= $pagetitle.ucwords(isset($page)?$page.' ':'').$website.' '.strtoupper(SITE_NAME)?></title>
        @include('layouts.sidebar')
