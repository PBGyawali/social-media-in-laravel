<div class="bigtext">
Welcome to "<?= $info->website_name; ?>"

</div>
<div class="" >
  <img src="<?= $info->website_logo; ?>"class="image ">
</div>
<span class="position-absolute text-center w-100 message" id="message" style="z-index:10;">
<?php displaymessage('',$errors);?>
</span>
