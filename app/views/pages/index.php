<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<?php flash("registered_successfully"); ?>
<!-- Add post Modal -->
<?php flash("post_created"); ?>
<?php flash("post_updated"); ?>
<?php flash("post_not_updated"); ?>
<?php
$display = $data['display'];
$myposts_page = $data['myposts_page'];
$count_myposts = $data['count_myposts'];
$per_myposts_page = $data['per_myposts_page'];
$myfriends_posts_page = $data['myfriends_posts_page'];
$count_myfriends_posts = $data['count_myfriends_posts'];
$per_myfriends_posts_page = $data['per_myfriends_posts_page'];
$count_myfriends_posts_for_pagination = ceil($count_myfriends_posts/$per_myfriends_posts_page);
$count_myposts_for_pagination = ceil($count_myposts/$per_myposts_page);
if(is_int($myposts_page) && is_int($myposts_page) && is_int($myfriends_posts_page) && is_int($myfriends_posts_page)){
$back_myposts = $myposts_page - 1;
$for_myposts = $myposts_page + 1;
$back_myfriends_posts = $myfriends_posts_page - 1;
$for_myfriends_posts = $myfriends_posts_page + 1;
}else{
	
}
?>
<div role="main" class="container" style="margin-top: 70px;">
	<div class="row">
		<div class="col-md-3 mt-2" style="position:fixed;">
		<?php require APPROOT . '/views/inc/sidebar.php'; ?>
		<div class="modal fade" id="add-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		</div>
	</div>
		<div class="col-md-8 offset-md-4 mt-4">
			<form action="<?php echo URLROOT ; ?>/searchs/searchMyFriendsPosts" method="post" class="">
        <div class="input-group input-group-sm">
        <input type="text" class="form-control" name="search_content_myfriends_posts" placeholder="Search for my friends posts">
        <div class="input-group-append">
        <button type="submit" name="search_myfriends_posts" class="input-group-text"><i class="fa fa-search"></i></button></div>
        </div>
      </form><br>
			<?php foreach($data['myfriends_posts'] as $myfriends_posts): ?>
				<div class="card mb-4">
					<?php
                $post_user = $user->findUserById($myfriends_posts->post_user_id);
                $post_user_name = $post_user->user_name;
                if ($myfriends_posts->post_image !== 'no image' && !empty($myfriends_posts->post_image)):
                ?><img class='card-img-top' style="width:100%" src="<?php echo URLROOT . "/images/posts_images/" . $post_user_name .  "_images/" . $myfriends_posts->post_image ?>" alt='Card image cap'>
<?php endif; ?>
				<div class="card-body">
			<?php if($myfriends_posts->post_category_id == 15): ?>
<a class="mt-2 btn" style="float: right; font-weight: 10px;background-color: rgb(204, 170, 255);">Quarantine day 53</a>
<?php endif; ?>
	              <h2 class="card-title"><?php echo $myfriends_posts->post_title ?></h2>
	              <p class="card-text"><?php echo $myfriends_posts->post_content; ?></p>
<?php if($myfriends_posts->post_category_id == 15): ?>
	              <h3 class="card-title">Lesson learnt</h3>
	              <p class="card-text"><?php echo $myfriends_posts->diary_lesson_learnt; ?></p>
<?php endif; ?>
						</div><div class="card-footer">
							<?php
					$likes = new Likes();
					$user = new Users();
					$relates = new Relates();
					if($likes->liked($myfriends_posts->post_id)){
						?>
						<style type="text/css">
							.like_icon_<?php echo $myfriends_posts->post_id; ?>{
								color: #ffb380;
							}
							.like_icon_<?php echo $myfriends_posts->post_id; ?>:hover{
								color: #ffb380;
							}
						</style>
						<?php
					}else{
						?>
						<style type="text/css">
							.like_icon_<?php echo $myfriends_posts->post_id; ?>{
							  color: grey;
							}
							.like_icon_<?php echo $myfriends_posts->post_id; ?>:hover{
							  color: #ffb380;
							}
						</style>
					<?php } 
					if($relates->related($myfriends_posts->post_id)){
						?>
						<style type="text/css">
							.relate_icon_<?php echo $myfriends_posts->post_id; ?>{
								color: #ccaaff;
							}
							.relate_icon_<?php echo $myfriends_posts->post_id; ?>:hover{
								color: #ccaaff;
							}
						</style>
						<?php
					}else{
						?>
						<style type="text/css">
							.relate_icon_<?php echo $myfriends_posts->post_id; ?>{
							  color: grey;
							}
							.relate_icon_<?php echo $myfriends_posts->post_id; ?>:hover{
							  color: #ccaaff;
							}
						</style>
						<?php
						}
					?>
					<?php if($myfriends_posts->post_request_help == 1): ?>
					<div class="d-flex justify-content-between">
						<div class="p-2 align-self-center">
							<div class="btn-group" role="group" aria-label="Basic example">
  <form action="<?php echo URLROOT . "/likes/likePost/" . $myfriends_posts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn like_button_<?php echo $myfriends_posts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="fas fa-hand-holding-heart like_icon_<?php echo $myfriends_posts->post_id; ?> like_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myfriends_posts->post_likes_count; ?> feel better<?php
								if($myfriends_posts->post_likes_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							<form action="<?php echo URLROOT . "/relates/relatePost/" . $myfriends_posts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn relate_button_<?php echo $myfriends_posts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="far fa-hand-paper relate_icon_<?php echo $myfriends_posts->post_id; ?> relate_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myfriends_posts->post_relates_count; ?> relate<?php
								if($myfriends_posts->post_relates_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							</div>
						</div>
  <div class="p-2 align-self-center"><?php echo $myfriends_posts->post_date; ?></div>
  <div class="p-2 align-self-center">posted by: <?php echo $myfriends_posts->post_author; ?></div>
  <?php
  $user = new Users();
  if($user->is_friend($myfriends_posts->post_user_id)){
  ?>
    <div class="p-2 align-self-center"><a href="<?php echo URLROOT . "/chats/read/{$_SESSION['user_id']}/{$myfriends_posts->post_user_id}" ?>" style="background-color: #ffb380; color: black;" class="btn btn-sm btn-block">I can help</a></div>
  <?php
  }else{
  ?>
      <div class="p-2 align-self-center"><form action="<?php echo URLROOT; ?>/users/accept/<?php echo $myfriends_posts->post_user_id; ?>" method="post" class="">
                        <input type="submit" style="background-color: #ffb380;" class="btn btn-sm" name="accept_request<?php echo $myfriends_posts->post_user_id ; ?>" value="I can help">
                    </form></div>
<?php } ?>
						</div>
						<?php else: ?>
<div class="d-flex justify-content-between">
						<div class="p-2 align-self-center">
							<div class="btn-group" role="group" aria-label="Basic example">
  <form action="<?php echo URLROOT . "/likes/likePost/" . $myfriends_posts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn like_button_<?php echo $myfriends_posts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="fas fa-hand-holding-heart like_icon_<?php echo $myfriends_posts->post_id; ?> like_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myfriends_posts->post_likes_count; ?> feel better<?php
								if($myfriends_posts->post_likes_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							<form action="<?php echo URLROOT . "/relates/relatePost/" . $myfriends_posts->post_id; ?>" onsubmit="return likeSubmit();">
								<button class="btn relate_button_<?php echo $myfriends_posts->post_id; ?> like_button_hover" style="padding-top:0px;padding-bottom:0px;"><i class="far fa-hand-paper relate_icon_<?php echo $myfriends_posts->post_id; ?> relate_icon_hover" style="margin-left: -12px;padding-bottom: 2px;"><span style="margin-left:2px;"> <?php echo $myfriends_posts->post_relates_count; ?> relate<?php
								if($myfriends_posts->post_relates_count>1){
									echo "s";
								}
								?></span></i></button>
							</form>
							</div>
						</div>
  <div class="p-2 align-self-center"><?php echo $myfriends_posts->post_date; ?></div>
  <div class="p-2 align-self-center">posted by: <?php echo $myfriends_posts->post_author; ?></div>
						</div>
						<?php endif; ?>
					</div>						
				</div><br>
			<?php endforeach; ?>
		</div>
	</div></div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>