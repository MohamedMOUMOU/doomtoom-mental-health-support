<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT . '/css/profile.css'; ?>">
<?php require APPROOT . '/views/inc/navbar.php'; ?> 
	<div class="container">
		<div class="row" style="margin-top: 70px">
		<div class="col-md-3 mt-3" style="position:fixed;">
		<?php require APPROOT . '/views/inc/sidebar.php'; ?>
		<div class="modal fade" id="add-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		</div></div>
			<div class="col-md-8 offset-md-4 mt-3">
				<center><h1 style="color:#ffb380;">My participations</h1></center><br>
				<?php
				foreach ($data['show_my_participations'] as $myposts) { ?>
					<div class="card mb-4">
					<?php
                $post_user = $user->findUserById($myposts->post_user_id);
                $post_user_name = $post_user->user_name;
                if ($myposts->post_image):
                ?><img class='card-img-top' style="width:100%" src="<?php echo URLROOT . "/images/posts_images/" . $post_user_name .  "_images/" . $myposts->post_image ?>" alt='Card image cap'>
            <?php endif; ?>
				<div class="card-body">
					<?php if($myposts->post_category_id == 15): ?>
						<a class="mt-2 btn" style="float: right; font-weight: 10px;background-color: rgb(204, 170, 255);">Quarantine day 53</a>
					<?php endif; ?>
	              <h2 class="card-title"><?php echo $myposts->post_title ?></h2>
	              <p class="card-text"><?php echo $myposts->post_content; ?></p>
		              <?php if($myposts->post_category_id == 15): ?>
		              <h3 class="card-title">Lesson learnt</h3>
		              <p class="card-text"><?php echo $myposts->diary_lesson_learnt; ?></p>
	          		<?php endif; ?>
	      			<?php
					$likes = new Likes();
					$post = new Posts();
					$user = new Users();
					$relates = new Relates();
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
					if($relates->related($myposts->post_id)){
						?>
						<style type="text/css">
							.relate_icon_<?php echo $myposts->post_id; ?>{
								color: #ccaaff;
							}
							.relate_icon_<?php echo $myposts->post_id; ?>:hover{
								color: #ccaaff;
							}
						</style>
						<?php
					}else{
						?>
						<style type="text/css">
							.relate_icon_<?php echo $myposts->post_id; ?>{
							  color: grey;
							}
							.relate_icon_<?php echo $myposts->post_id; ?>:hover{
							  color: #ccaaff;
							}
						</style>
						<?php
						}
					?>
						</div><div class="card-footer">
<div class="d-flex justify-content-between">
						<div class="p-2 align-self-center">
							<div class="btn-group" role="group" aria-label="Basic example">
  <form action="<?php echo URLROOT . "/likes/likePost/" . $myposts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn like_button_<?php echo $myposts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="fas fa-hand-holding-heart like_icon_<?php echo $myposts->post_id; ?> like_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myposts->post_likes_count; ?> feel better<?php
								if($myposts->post_likes_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							<form action="<?php echo URLROOT . "/relates/relatePost/" . $myposts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn relate_button_<?php echo $myposts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="far fa-hand-paper relate_icon_<?php echo $myposts->post_id; ?> relate_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myposts->post_relates_count; ?> relate<?php
								if($myposts->post_relates_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							</div>
						</div>
  <div class="p-2 align-self-center"><?php echo $myposts->post_date; ?></div>
  <div class="p-2 align-self-center">posted by: <?php echo $myposts->post_author; ?></div>
						</div></div>
							
				</div><br>
				<?php
				}
				?>
			</div>
		</div>
	</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>