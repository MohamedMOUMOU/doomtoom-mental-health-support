<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<style>
  /*
*
* ==========================================
* FOR DEMO PURPOSES
* ==========================================
*
*/
body {
  background-color: #74EBD5;
  background-image: linear-gradient(90deg, rgb(204, 170, 255) 0%, rgb(255, 179, 128) 100%);

  height: 100vh;
}

::-webkit-scrollbar {
  width: 5px;
}

::-webkit-scrollbar-track {
  width: 5px;
  background: #f5f5f5;
}

::-webkit-scrollbar-thumb {
  width: 1em;
  background-color: #ddd;
  outline: 1px solid slategrey;
  border-radius: 1rem;
}

.text-small {
  font-size: 0.9rem;
}

.messages-box,
.chat-box {
  height: 510px;
  overflow-y: scroll;
}

.rounded-lg {
  border-radius: 0.5rem;
}

input::placeholder {
  font-size: 0.9rem;
  color: #999;
}

</style>
<div style="padding-top: 80px;" class="container px-4">
  <div class="row rounded-lg overflow-hidden shadow center">
    <!-- Users box-->
    <div class="col-5 px-0">
      <div class="bg-white">

        <div class="bg-gray px-4 py-2 bg-light">
          <p class="h5 mb-0 py-1"><?php echo $data['group']->group_name; ?>'s discussion<small classe="text-muted" style="float:right;">Gathering theme: <?php echo $data['group']->group_theme; ?></small></p>
        </div>

        <div class="messages-box">
          <div class="list-group rounded-0">
            <div class="get_members"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Chat Box-->
    <div class="col-7 px-0">
      <div class="px-4 pt-5 pb-0 chat-box bg-white">
<?php
			foreach ($data['messages'] as $message) {
            if($message->sender_id === $_SESSION['user_id']){
          ?>
        <div class="media w-50 ml-auto mb-3">
          <div class="media-body">
            <div message-id='<?php echo $message->id; ?>' class="rounded py-2 px-3 mb-2" style="background-color: rgb(204, 170, 255);" id='my-message-<?php echo $message->id; ?>' data-toggle='modal' data-target='#my_message_<?php echo $message->id; ?>'>
              <p class="text-small mb-0 text-white"><?php echo $message->message; ?></p>
            </div>
            <p class="small text-muted"><?php echo chat_dates($message->creation_time); ?></p>
          </div>
        </div>

        <?php }else{ ?>
        <!-- Reciever Message-->
        <?php
        $user = new Users();
        $fuser = $user->findUserById($message->sender_id);
        ?>
                <div class="media w-50 mb-3"><img src="<?php echo profile_image($fuser); ?>" alt="user" width="50" height="50" class="rounded-circle">
          <div class="media-body ml-3">
            <div class="rounded py-2 px-3 mb-2" style="background-color: rgb(255, 179, 128);">
              <p class="text-small mb-0 text-muted"><?php echo $message->message; ?></p>
            </div>
            <p class="small text-muted"><?php echo chat_dates($message->creation_time); ?></p>
          </div>
        </div>
      <?php }} ?>
  </div>
      <!-- Typing area -->
      <form action="<?php echo URLROOT . "/groupsmessages/send_message/" . $_SESSION['user_id'] . "/" . $data['group']->group_id; ?>" method="post" class="bg-light" enctype="multipart/form-data">
        <div class="input-group">
          <input type="text" aria-describedby="button-addon2" class="form-control rounded-0 border-0 py-4 bg-light" placeholder="The group is waiting for your message" name="group_message" required>
          <div class="input-group-append">
            <button id="button-addon2" type="submit" class="btn btn-link"> <i class="fa fa-paper-plane"></i></button>
          </div>
        </div>
      </form>
       </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>