<?php
session_start();
// flash message helper
function flash($name = '',$message = '',$flash_message_cat = ''){
	if(!empty($name)){
		if(!empty($message) && empty($_SESSION[$name])){
			if(!empty($_SESSION[$name])){
				unset($_SESSION[$name]);
			}
			if(!empty($_SESSION[$name . '_class'])){
				unset($_SESSION[$name . '_class']);
			}
		$_SESSION[$name] = $message;
		$_SESSION[$name . '_class'] = $flash_message_cat;
	}elseif(empty($message) && !empty($_SESSION[$name])){
		?>
		<div class="container-fluid con" style="display:none;background-color:rgba(0, 0, 0, 0.5);position:absolute;top:0px;left:0;z-index:2;width:100%;">
			<div class="row align-items-center" style="height:100vh;">
				<div class="col-md-4 offset-md-4 mx-auto flash-message" style="">
					<div class="card card-body bg-light mt-5" style="padding: 0px 10px 10px 10px;">
						<b class="ml-auto"><span class="text-muted close-flash-message" style="font-size:30px;cursor:pointer;">&times;</span></b>
						<div class="text-center">
						<i style="<?php echo ($_SESSION[$name . '_class'] == 'error') ? 'color:#c9302c;' : 'color:#28a745;';?>font-size:100px;margin-bottom:10%;" class="<?php echo ($_SESSION[$name . '_class'] == 'error') ? 'fa fa-times-circle' : 'fa fa-check-circle';?>"></i>
						</div>
					<h4 class="text-center"><?php echo $_SESSION[$name]; ?></h4>
				</div>
			</div>
		</div>
	</div>
	<?php
		unset($_SESSION[$name]);
		unset($_SESSION[$name . "_class"]);
		}
	}
}
?>