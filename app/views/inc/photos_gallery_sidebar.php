<?php
if($data['liked']){
	?>
		<style>
			.like_button{
				background-color: #7c7cff;
			}
		</style>
	<?php
}else{
	?>
		<style>
			.like_button{
				background-color: gray;
			}
		</style>
	<?php
}
?>
<?php
if($data['disliked']){
	?>
		<style>
			.dislike_button{
				background-color: #ff7a7a;
			}
		</style>
	<?php
}else{
	?>
		<style>
			.dislike_button{
				background-color: gray;
			}
		</style>
	<?php
}
?>
<div class="row m-3">
	<div class="col-3">
		<img style="height: 60px;width: 60px;border-radius: 250px;" src="<?php echo URLROOT . "/images/users_images/" . $data['user_name'] . "_images/profile_images/" . $data['user_image']; ?>" alt="">
	</div>
	<div class="col-9 text-center">
		<h3 class=""><?php echo ($data['photos_gallery']->gallery_id !== $_SESSION['photos_gallery_id']) ? $data['user_name'] . "'s" : 'My'; ?> photos gallery</h3>
	</div>
</div>
<div class="row">
	<div class="col-12 text-center">
		<div class="btn-group pb-3" role="group" aria-label="Basic example">
			<form style="display: inline;" action="<?php echo URLROOT . "/gallerieslikes/like_gallery/" . $data['photos_gallery']->gallery_id; ?>">
				<button type="submit" class="btn btn-secondary like_button"><i class="fa fa-thumbs-up"></i> <?php echo $data['photos_gallery']->likes_count ?></button>
			</form>
			<form style="display: inline;" action="<?php echo URLROOT . "/galleriesdislikes/dislike_gallery/" . $data['photos_gallery']->gallery_id; ?>">
				<button type="submit" class="btn btn-secondary dislike_button"><i class="fa fa-thumbs-down"> <?php echo $data['photos_gallery']->dislikes_count ?></i></button>
			</form>
		</div>	
	</div>
</div>
<div class="row mb-3">
<div class="col-6" style="margin: auto;">
	<h5 class="text-center text-gradient personal_gallery">Gallery images</h5>
</div>
<div class="col-6">
	<?php $i = 0; ?>
	<div class="img-thumbnail personal_gallery" style="display: block;">
		<?php if($data['personal_galleries_media_count'] == 0): ?>
			<img class='img-fluid ' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/website_images/empty_personal_gallery.png"; ?>' alt=''>
		<?php elseif($data['personal_galleries_media_count'] == 1): ?>
			<?php foreach($data['personal_galleries_media_1'] as $photo): ?>
			<img personal-image-id='{$photo->personal_gallery_id}' class='img-fluid' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/" . $photo->personal_gallery_media;?>' alt=''>
		<?php endforeach; ?>
		<?php elseif($data['personal_galleries_media_count'] == 2): ?>
			<?php foreach($data['personal_galleries_media_2'] as $photo):
				echo "<img personal-image-id='{$photo->personal_gallery_id}' class='img-fluid' style='width:48%;height:70px;display:inline;' src='" . URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/{$photo->personal_gallery_media}' alt=''>";
			$i++; ?>
			<?php endforeach; ?>
		<?php elseif($data['personal_galleries_media_count'] == 3): ?>
			<?php foreach($data['personal_galleries_media_3'] as $photo):
			if($i == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				if ($i == 2):
					echo "<img personal-image-id='{$photo->personal_gallery_id}' class='img-flui' style='width:70%;height:50px;display: inline;padding-left:25%' src='" . URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/{$photo->personal_gallery_media}' alt=''>";
				elseif($i == 1):
					echo "<img personal-image-id='{$photo->personal_gallery_id}' class='img-flui ml-1' style='width:48%;height:50px;display: inline' src='" . URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/{$photo->personal_gallery_media}' alt=''>";
				else:
					echo "<img personal-image-id='{$photo->personal_gallery_id}' class='img-flui' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/{$photo->personal_gallery_media}' alt=''>";
				endif;
			if($i%2 == 1): ?>
			</div>
			<?php endif;
			$i++;
			endforeach; ?>
		<?php elseif($data['personal_galleries_media_count'] >= 4): ?>
			<?php foreach($data['personal_galleries_media_4'] as $photo): ?>
			<?php if($i%2 == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				echo "<img personal-image-id='{$photo->personal_gallery_id}' class='img-flui' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/gallery_images/" . $data['user_name'] . "_images/{$photo->personal_gallery_media}' alt=''>";
			if($i%2 == 1): ?>
			</div>
			<?php endif; ?>
			<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
</div>
<hr>
<div class="row mb-3 mt-2">
<div class="col-6" style="margin: auto;">
	<h5 class="text-gradient profile_gallery">Profile images</h5>
</div>
<div class="col-6">
	<?php $i = 0; ?>
	<?php
		function define_dir($cat){
			if($cat == "profile_images"){
				return "profile_images";
			}else{
				return "pbi_images";
			}
		}
	?>
	<div class="img-thumbnail profile_gallery" style="display: block;">
		<?php if($data['users_galleries_media_count'] == 0): ?>
			<img class='img-fluid ' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/website_images/empty_profile_gallery.png"; ?>' alt=''>
		<?php elseif($data['users_galleries_media_count'] == 1): ?>
			<?php foreach($data['users_galleries_media_1'] as $photo):
				if($photo->category === "{profile_images}"){
					$dir = "{profile_images}";
				}else{
					$dir = "pbi_images";
				}
			?>
			<img profile-image-id='{$photo->users_gallery_id}' class='img-fluid' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/" . $photo->users_gallery_media;?>' alt=''>
		<?php endforeach; ?>
		<?php elseif($data['users_galleries_media_count'] == 2): ?>
			<?php foreach($data['users_galleries_media_2'] as $photo):
				echo "<img profile-image-id='{$photo->users_gallery_id}' class='img-fluid' style='width:48%;height:70px;display:inline;' src='" . URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/{$photo->users_gallery_media}' alt=''>";
			$i++; ?>
			<?php endforeach; ?>
		<?php elseif($data['users_galleries_media_count'] == 3): ?>
			<?php foreach($data['users_galleries_media_3'] as $photo):
			if($i == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				if ($i == 2):
					echo "<img profile-image-id='{$photo->users_gallery_id}' class='img-fluid' style='width:70%;height:50px;display: inline;padding-left:25%' src='" . URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/{$photo->users_gallery_media}' alt=''>";
				elseif($i == 1):
					echo "<img class='img-fluid ml-1' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/{$photo->users_gallery_media}' alt=''>";
				else:
					echo "<img profile-image-id='{$photo->users_gallery_id}' class='img-fluid' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/{$photo->users_gallery_media}' alt=''>";
				endif;
			if($i%2 == 1): ?>
			</div>
			<?php endif;
			$i++;
			endforeach; ?>
		<?php elseif($data['users_galleries_media_count'] >= 4): ?>
			<?php foreach($data['users_galleries_media_4'] as $photo): ?>
			<?php if($i%2 == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				echo "<img profile-image-id='{$photo->users_gallery_id}' class='img-fluid' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/users_images/" . $data['user_name'] . "_images/" . define_dir($photo->category) . "/{$photo->users_gallery_media}' alt=''>";
			if($i%2 == 1): ?>
			</div>
			<?php endif; ?>
			<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
</div>
<hr>
<div class="row mb-3">
<div class="col-6" style="margin: auto;">
	<h5 class="text-center text-gradient posts_gallery">Posts images</h5>
</div>
<div class="col-6">
	<?php $i = 0; ?>
	<div class="img-thumbnail posts_gallery" style="display: block;">
		<?php if($data['posts_galleries_media_count'] == 0): ?>
			<img class='img-fluid ' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/website_images/empty_p_gallery.png"; ?>' alt=''>
		<?php elseif($data['posts_galleries_media_count'] == 1): ?>
			<?php foreach($data['posts_galleries_media_1'] as $photo): ?>
			<img class='img-fluid' style='width:100%;height:100px;' src='<?php echo URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/" . $photo->posts_gallery_media;?>' alt=''>
		<?php endforeach; ?>
		<?php elseif($data['posts_galleries_media_count'] == 2): ?>
			<?php foreach($data['posts_galleries_media_2'] as $photo):
				echo "<img class='img-fluid' style='width:48%;height:70px;display:inline;' src='" . URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/{$photo->posts_gallery_media}' alt=''>";
			$i++; ?>
			<?php endforeach; ?>
		<?php elseif($data['posts_galleries_media_count'] == 3): ?>
			<?php foreach($data['posts_galleries_media_3'] as $photo):
			if($i == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				if ($i == 2):
					echo "<img class='img-fluid' style='width:70%;height:50px;display: inline;padding-left:25%' src='" . URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/{$photo->posts_gallery_media}' alt=''>";
				elseif($i == 1):
					echo "<img class='img-fluid ml-1' style='width:48%;height:50px;display: inline' src='" . URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/{$photo->posts_gallery_media}' alt=''>";
				else:
					echo "<img class='img-fluid' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/{$photo->posts_gallery_media}' alt=''>";
				endif;
			if($i%2 == 1): ?>
			</div>
			<?php endif;
			$i++;
			endforeach; ?>
		<?php elseif($data['posts_galleries_media_count'] >= 4): ?>
			<?php foreach($data['posts_galleries_media_4'] as $photo): ?>
			<?php if($i%2 == 0): ?>
			<div class="<?php echo ($i === 0) ? 'mb-1' : ''; ?>" style="display: block;">
			<?php endif;
				echo "<img class='img-fluid ' style='width:48%;height:50px;display: inline;' src='" . URLROOT . "/images/posts_images/" . $data['user_name'] . "_images/{$photo->posts_gallery_media}' alt=''>";
			if($i%2 == 1): ?>
			</div>
			<?php endif; ?>
			<?php $i++; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
</div>