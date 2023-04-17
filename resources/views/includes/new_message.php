<?php
function displaymessage($display=true,$errors=null){
    $errortypes=array('email','login_email','registered_email','registered_username',
    'reset_email','username','password','password_confirmation','provider',);
    foreach( $errortypes as $type){
   if ($errors->has($type)){
    echo '<div class="text-center bg-danger alert alert-danger text-white border-0 message alert-dismissible fade show ">
        <p >'. $errors->first($type) .'</p>
        <button type="button" class="close" onclick="hide()">&times;</button>
    </div>';
   }
}
	$types=array('success','info','warning','error','message','danger');
	$showtypes=array('success','info','warning','danger','warning','danger');
	foreach($types as $key=>$type){
		if(session()->has($type)) {
            echo '
            <div class="text-center bg-'.$showtypes[$key].' alert alert-'.$showtypes[$key].'
             text-white border-0 alert-dismissible fade show message">
                        <p >'. session($type) .'</p>
            <button type="button" class="close" onclick="hide()">&times;</button>
                    </div>';

		}
	}
}
?>
