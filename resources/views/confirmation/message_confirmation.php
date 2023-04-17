<?php  echo $__env->make('config', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render();
?>
<?php
include_once(INCLUDES.'login_head_section.php');
include_once(INCLUDES.'sidebar.php'); ?>
<script type="text/javascript" src="<?= JS_URL?>history.js"></script>
<title>Thank you!</title>
</head>
   <body>
         <h2 class="position-absolute w-100 text-center text-white inset-1/2" style="
            transform: translate(-50%, -50%)"><p>
                  Thank you <?= isset($fullname)&& !empty($fullname)?$fullname:'sir/madam'?> for your
                  time to send us the message.</p>  We will reply you back as soon as possible in your given email
                  <?= isset($email)&& !empty($email)?$email:'if you have given one'?>.
                  :)
         </h2>

   </body>
</html>
<?php include_once(INCLUDES.'minimal_footer.php');?>
@include('footer_script')
