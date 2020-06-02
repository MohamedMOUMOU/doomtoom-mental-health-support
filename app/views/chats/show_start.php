<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<style type="text/css">
	.friend-<?php echo $data['receiver']->user_id; ?>{
		background-color: rgba(0, 0, 0 , 0.1);
	}
</style>
<div role="main" class="container-fluid" style="margin-top: 70px;">
	<div class="row">
		<div class="col-md-3 scroll-sidebar1" style="overflow: auto;height: 87vh;">	
			<?php require APPROOT . '/views/inc/chat_room_sidebar.php'; ?>
		</div>
		<style type="text/css">
			.chat-section{
				background-image: url('<?php echo URLROOT . "/images/website_images/start-chat-image.png";?>');
				background-repeat: no-repeat;
				background-size: cover;
				background-position: center;
			}
		</style>
		<div class="col-md-9 offset-md-3 chat-section">
			
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>