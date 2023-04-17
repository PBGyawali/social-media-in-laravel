<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
?>
<!DOCTYPE html>
<html lang="<?= e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="<?= e(csrf_token()); ?>">
  <link rel="stylesheet" href="<?= CSS_URL.'http_errors.css'?>">

  <link rel="stylesheet" href="<?= CSS_URL?>bootstrap.min.css">
  <title><?= isset($title)?$title:'error'?></title>
</head>
<body>
<div id="wrap">
    <div id="wordsearch">
      <ul>
