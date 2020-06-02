<?php
$user = new Users();
$post = new Posts();
$last_seen_posts = $post->last_seen_posts();
$recently_liked_posts = $post->recently_liked_posts();
$wich_post = "";
$like = new Profilelikes();
$dislike = new Profiledislikes();
?>
<?php
if($like->likedprofile($_SESSION['user_id'])){
	?>
		<style>
			.like-button{
				background-color: #7c7cff;
			}
		</style>
	<?php
}else{
	?>
		<style>
			.like-button{
				background-color: gray;
			}
		</style>
	<?php
}
?>
<?php
if($dislike->dislikedprofile($_SESSION['user_id'])){
	?>
		<style>
			.dislike-button{
				background-color: #ff7a7a;
			}
		</style>
	<?php
}else{
	?>
		<style>
			.dislike-button{
				background-color: gray;
			}
		</style>
	<?php
}
?>
<div class="logged-in-user row pb-2">
	<div class="col-md-5">
		<img style="height: 100px;width: 100px;border-radius: 250px;" src="<?php echo profile_image($data['logged_in_user']);?>" alt="">
	</div>
	<div class="col-md-7 text-center">
		<div class="btn-group" role="group" aria-label="Basic example" style="margin-top: 30px;">
			<form style="display: inline;" action="<?php echo URLROOT . "/profilelikes/likeProfile/" . $data['logged_in_user']->user_id; ?>">
				<button type="submit" class="btn btn-secondary like-button"><i class="fa fa-thumbs-up"></i> <?php echo $data['logged_in_user']->profile_likes_count ?></button>
			</form>
			<form style="display: inline;" action="<?php echo URLROOT . "/profiledislikes/dislikeProfile/" . $data['logged_in_user']->user_id; ?>">
				<button type="submit" class="btn btn-secondary dislike-button"><i class="fa fa-thumbs-down"> <?php echo $data['logged_in_user']->profile_dislikes_count ?></i></button>
			</form>
		</div>	
	</div>
</div>
<div class="b-image">
	<img src="<?php echo URLROOT . "/images/website_images/white.png"; ?>" class="b-o-image" alt="">
</div>
<a href="#" style="margin-top: 115px;" class="nav-link"><div class="loggedin"></div></a>
