<?php if (auth()->user()&& auth()->user()->is_editor()) :?>
   <?= BASE_URL.'admin/'?>
<?php   elseif (auth()->user() && auth()->user()->is_user()):?>
  <?= route('home')?>
<?php   elseif (session()->has('guest')):?>
  <?= route('welcome')?>
<?php  else:?>
      <?= BASE_URL?>
 <?php  endif?>
