<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT . '/css/profile.css'; ?>">
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php flash("not change profile image"); ?>
<?php flash("not change pbi image"); ?>
<?php flash("not change self description"); ?>
    <div class="container">
        <div class="row first-row">
        	<?php
        	if($data['user_info']->user_pbi == "default-pbi.png"){
        		$pbi = URLROOT . "/images/website_images/" . $data['user_info']->user_pbi;
        	}else{
        		$pbi = URLROOT . "/images/users_images/" . $data['user_info']->user_name . "_images/pbi_images/" . $data['user_info']->user_pbi;
        	}
        	?>
            <a href="" style="width: 96%;" data-toggle="modal" data-target="#change_pbi"><img style="width:100%;height:51.5vh;" class="img-responsive" src="<?php echo $pbi; ?>" alt=""></a>
            <div class="modal fade" id="change_pbi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Change your profile background image</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
					<form action="<?php echo URLROOT; ?>/users/change_pbi_image/<?php echo $data['user_info']->user_id; ?>" method="post" enctype="multipart/form-data">
						<input type="file" name="pbi_image" class="form-control">
						<input type="submit" value="Save changes" name="change_pbi_image" class="btn btn-primary pull-right">
					</form>
			      </div>
			    </div>
			  </div>
			</div>
        	<?php
        	if($data['user_info']->user_image == "unknown-profile.jpg" || $data['user_info']->user_image == 'unknown-profile-woman.jpg'){
        		$user_image = URLROOT . "/images/website_images/" . $data['user_info']->user_image;
        	}else{
        		$user_image = URLROOT . "/images/users_images/" . $data['user_info']->user_name . "_images/profile_images/" . $data['user_info']->user_image;
        	}
        	?>
            <a href="" data-toggle="modal" data-target="#exampleModal"><img class="profile-image" src="<?php echo $user_image; ?>"></a>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Change your profile image</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
					<form action="<?php echo URLROOT; ?>/users/change_profile_image/<?php echo $data['user_info']->user_id; ?>" method="post" enctype="multipart/form-data">
						<input type="file" name="profile_image" class="form-control">
						<input type="submit" value="Save changes" name="change_profile_image" class="btn btn-primary pull-right">
					</form>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="buttons-section" style="float:left">
								<?php
                if($message == "block"):
                ?>
                	<a href="<?php echo URLROOT . "/chats/read/{$_SESSION['user_id']}/{$data['user_info']->user_id}" ?>" style="border-radius: 0px;" style="background-color: rgb(255, 179, 128);" class="btn"> Send message</a>
                <?php
                else:
                    ?>
					<form action="<?php echo URLROOT; ?>/users/accept/<?php echo $data['user_info']->user_id; ?>" method="post" class="">
                        <input type="submit" style="border-radius: 0;" style="background-color: rgb(255, 179, 128);" class="btn" name="accept_request<?php echo $data['user_info']->user_id ; ?>" value="send message">
                    </form>                    <?php
                endif;
                ?></div>
							</div>
						</div>
					</div>
			</div>
        </div>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-3 mt-3">
				<div><h5>Self description :<i style="cursor: pointer;" data-toggle="modal" data-target="#self-description" class="fa fa-edit pull-right"></i></h5><div class="scroll-self-desc self-desc-text"><?php echo (!empty($data['user_info']->user_self_description)) ? $data['user_info']->user_self_description : "<h3 class='text-center' style='padding-top: 37px;'>this field is empty</h3>"; ?></div></div>
            <div class="modal fade" id="self-description" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Edit yourself description</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
					<form action="<?php echo URLROOT; ?>/users/edit_self_description/<?php echo $data['user_info']->user_id; ?>" method="post">
						<textarea type="text" id="editor" name="self_description" class="form-control"><?php echo $data['user_info']->user_self_description; ?></textarea><br>
						<input type="submit" value="Save changes" name="submit_self_description" class="btn btn-primary pull-right">
					</form>
			      </div>
			    </div>
			  </div>
			</div>
			</div>
			<div class="col-9 mt-3">
				<?php
				foreach ($data['posts_info'] as $myposts) { ?>
					<div class="card mb-4">
					<?php
                if ($myposts->post_image):
                $post_user = $user->findUserById($myposts->post_user_id);
                $post_user_name = $post_user->user_name;
                ?><img class='card-img-top' style="width:100%" src="<?php echo URLROOT . "/images/posts_images/" . $post_user_name .  "_images/" . $myposts->post_image ?>" alt='Card image cap'>
				<div class="card-body">
	              <h2 class="card-title"><?php echo $myposts->post_title ?></h2>
	              <p class="card-text"><?php echo $myposts->post_content; ?></p>
	      			<?php
					$likes = new Likes();
					$post = new Posts();
					$user = new Users();
					if($post->post_is_viewed($myposts->post_id)){
						?>
						<style type="text/css">
							.post_title{
								color : #ffb380;
							}
						</style>
						<?php
					}
					if($likes->liked($myposts->post_id)){
						?>
						<style type="text/css">
							.like_icon_<?php echo $myposts->post_id; ?>{
								color: #ffb380;
							}
							.like_icon_<?php echo $myposts->post_id; ?>:hover{
								color: #ffb380;
							}
						</style>
						<?php
					}else{
						?>
						<style type="text/css">
							.like_icon_<?php echo $myposts->post_id; ?>{
							  color: grey;
							}
							.like_icon_<?php echo $myposts->post_id; ?>:hover{
							  color: #ffb380;
							}
						</style>
					<?php } 
					?>
						</div><div class="card-footer">
					<div class="d-flex justify-content-between">
  					<div class="p-2"><form action="<?php echo URLROOT . "/likes/likePost/" . $myposts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn like_button_<?php echo $myposts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="fas fa-hand-holding-heart like_icon_<?php echo $myposts->post_id; ?> like_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"><?php echo $myposts->post_likes_count; ?> feel better<?php
								if($myposts->post_likes_count>1){
									echo "s";
								}
								?></span></i></button>
							</form></div>
  <div class="p-2">3 comments</div>
  <div class="p-2"><?php echo $myposts->post_date; ?></div>
  <div class="p-2">posted by: <?php echo $myposts->post_author; ?></div>
</div></div>
							
				<?php endif; ?></div><br>
				<?php
				}
				?>
			</div>
		</div>
	</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>