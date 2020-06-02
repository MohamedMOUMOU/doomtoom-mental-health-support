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
				background-image: url('<?php echo chat_images($data['logged_in_user']); ?>');
				background-repeat: no-repeat;
				background-size: cover;
				background-position: center;
			}
		</style>
		<div class="col-md-9 offset-md-3 chat-section">
			<?php
			$d = 1;
			$e = 1;
			foreach ($data['messages'] as $message) {
				$me = false;
				$other = false;
				if(!$me){
					$i = 0;
				}
				if(!$other){
					$c = 0;
				}
				if($message->sender_id === $_SESSION['user_id']){
					echo "<div class='row blue-row'>";
					$me = true;
					if(!$other){
						$i = 1;
						$e = 1;
					}
					if($d == 1){
						echo "<div message-id='{$message->id}' style='background-color: rgb(204, 170, 255);' id='my-message-{$message->id}' data-toggle='modal' data-target='#my_message_{$message->id}' class='offset-4 col-7 message message-blue message-blue-relative'>" . $message->message . "<span class='pull-right chat-date-blue'>" . chat_dates($message->creation_time) . "</span></div>";
					}else{
						echo "<div message-id='{$message->id}' id='my-message-{$message->id}' data-toggle='modal' data-target='#my_message_{$message->id}' class='offset-4 col-7 message message-blue'>" . $message->message . "<span class='pull-right chat-date-blue'>" . chat_dates($message->creation_time) . "</span></div>";
					}
					echo "<div class='col-1'><img class='chat-image' src='" . profile_image($data['logged_in_user']) . "'></div>";
					if($me){
						$d ++;
					}
					echo "</div>";
				}else{
					echo "<div class='row green-row'>";
					$other = true;
					if(!$me){
						$c = 1;
						$d = 1;
					}
					echo "<div class='col-1'><img class='chat-image' src='" . profile_image($data['receiver']) . "'></div>";
					if($e == 1){
						echo "<div message-id='{$message->id}' id='message-{$message->id}' style='background-color: rgb(255, 179, 128);' data-toggle='modal' data-target='#message_{$message->id}' class='col-7 message message-green message-green-relative'>" . $message->message . "<span class='pull-right chat-date-green'>" . chat_dates($message->creation_time) . "</span></div>";
					}else{
						echo "<div message-id='{$message->id}' id='message-{$message->id}' data-toggle='modal' data-target='#message_{$message->id}' class='col-7 message message-green'>" . $message->message . "<span class='pull-right chat-date-green'>" . chat_dates($message->creation_time) . "</span></div>";
					}
					if($other){
						$e ++;
					}
					echo "</div>";
				}
			}
			?>
		</div>
			<form action="<?php echo URLROOT . "/chats/send_message/" . $_SESSION['user_id'] . "/" . $data['receiver']->user_id; ?>" method="post" class="message-input">
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="<?php echo $data['receiver']->user_name . " is waiting for your message"; ?>" name="message">
					<div class="input-group-append">
					<button type="submit" class="btn btn-primary" type="button"><i class="fa fa-send"></i></button>
					</div>
				</div>
			</form>
	</div>
</div>
<div class="modal fade" id="change_chat_image" tabindex="91" role="dialog" aria-labelledby="change_group_image">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="change_group_image">Change your group image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form action="<?php echo URLROOT; ?>/users/change_chat_image/{$_SESSION['user_id']}" method="post" enctype="multipart/form-data">
			<input type="file" name="chat_image" class="form-control">
			<br>
			<input type="submit" value="Save changes" name="change_chat_image" class="btn btn-primary pull-right">
		</form>
      </div>
    </div>
  </div>
</div>
<div class="modal blue-message-modal" tabindex="91" role="dialog" aria-labelledby="change_group_name">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="change_group_name">Delete message options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form class="text-center" uncomplete-action="<?php echo URLROOT; ?>/chats/delete_for_me/" id="delete_for_me" method="post">
			<button class="delete-options" type="submit">Delete for me</button>
		</form>
		<form class="text-center" uncomplete-action2="<?php echo URLROOT; ?>/chats/delete_for_everyone/" id="delete_for_everyone" method="post">
			<button class="delete-options" type="submit">Delete for every_one</button>
		</form>
      </div>
    </div>
  </div>
</div>
<div class="modal green-message-modal" tabindex="91" role="dialog" aria-labelledby="change_group_name">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="change_group_name">Delete message options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form class="text-center" uncomplete-action="<?php echo URLROOT; ?>/chats/delete_o_for_me/" id="delete_o_for_me" method="post">
			<button class="delete-options" type="submit">Delete for me</button>
		</form>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>