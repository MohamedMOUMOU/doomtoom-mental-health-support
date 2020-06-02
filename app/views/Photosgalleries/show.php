<?php flash("photo_not_added"); ?>
<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT . '/css/photos_galleries_show.css'; ?>">
<?php require APPROOT . '/views/inc/navbar.php'; ?>
<div role="main" class="container-fluid" style="margin-top: 70px;">
	<div class="row">
		<div class="col-md-3 scroll-sidebar1" style="overflow: auto;height: 87vh;">	
			<?php require APPROOT . '/views/inc/photos_gallery_sidebar.php'; ?>
		</div>
		<div class="col-md-9 offset-md-3">
			<div class="personal_gallery_section">
			<h4><?php echo ($data['photos_gallery']->gallery_id !== $_SESSION['photos_gallery_id']) ? $data['user_name'] . "'s" : 'My'; ?> gallery images<span style="border-radius: 25px;" class="badge badge-primary pull-right"><?php echo $data['personal_galleries_media_count']; ?></span></h4>
			<img src="" class="big_personal_image mb-3 mt-2" alt="">
			<div class="gray-background"></div>
				<div class="personal-images-section">
					<?php
						$i = 0;
						foreach ($data['personal_galleries_media'] as $photo) {
							if($i%6 == 0){
								echo "<div class='row mb-3'>";
							}
							if($i == 0):
								echo "<div class='col-md-2'><img personal-image-id='{$photo->personal_gallery_id}' class='img-fluid rounded personal_images personal_images_1' src='" . URLROOT . "/images/gallery_images/{$data['user_name']}_images/{$photo->personal_gallery_media}' alt=''>";
							else:
								echo "<div class='col-md-2'><img personal-image-id='{$photo->personal_gallery_id}' class='img-fluid rounded personal_images' src='" . URLROOT . "/images/gallery_images/{$data['user_name']}_images/{$photo->personal_gallery_media}' alt=''>";
							endif;
							if($data['photos_gallery']->gallery_id === $_SESSION['photos_gallery_id']){
								echo "<form action='" . URLROOT . "/personalgalleries/delete/{$photo->personal_gallery_id}'><button type='submit' class='btn btn-danger delete-personal-images delete-personal-images-{$photo->personal_gallery_id}'><i class='fa fa-trash'></i></button></form>";
							}
							echo "</div>";
							if($i%6 == 5){
								echo "</div>";
							}elseif(($i+1) == $data['personal_galleries_media_count']){
								echo "</div>";
							}
							$i++;
						}
					?>
				</div>
			</div>
			<div class="profile_gallery_section">
				<h4><?php echo ($data['photos_gallery']->gallery_id !== $_SESSION['photos_gallery_id']) ? $data['user_name'] . "'s" : 'My'; ?> profile images<span style="border-radius: 25px;" class="badge badge-primary pull-right"><?php echo $data['users_galleries_media_count']; ?></span></h4>
				<img src="" class="big_u_image mb-3 mt-2" alt="">
				<div class="gray-background"></div>
				<div class="row">
					<div class="col-md-6">
						<?php
							$i = 0;
							foreach ($data['users_galleries_media_p_images'] as $photo) {
								if($i%3 == 0){
									echo "<div class='row mb-3'>";
								}
								if($i == 0):
									echo "<div class='col-md-4'><img u-image-id='{$photo->users_gallery_id}' class='img-fluid rounded u_images u_images_1' src='" . URLROOT . "/images/users_images/{$data['user_name']}_images/profile_images/{$photo->users_gallery_media}' alt=''>";
								else:
									echo "<div class='col-md-4'><img u-image-id='{$photo->users_gallery_id}' class='img-fluid rounded u_images' src='" . URLROOT . "/images/users_images/{$data['user_name']}_images/profile_images/{$photo->users_gallery_media}' alt=''>";
								endif;
								if($data['photos_gallery']->gallery_id === $_SESSION['photos_gallery_id']){
									echo "<form action='" . URLROOT . "/usersgalleries/delete/{$photo->users_gallery_id}'><button class='btn btn-danger delete-u-images delete-u-images-{$photo->users_gallery_id}'><i class='fa fa-trash'></i></button></form>";
								}
								echo "</div>";
								if($i%3 == 2){
									echo "</div>";
								}elseif(($i+1) == $data['users_galleries_media_count_p_images']){
									echo "</div>";
								}
								$i++;
							}
						?>
					</div>
					<div class="col-md-6">
						<?php
							$i = 0;
							foreach ($data['users_galleries_media_pbi_images'] as $photo) {
								if($i%3 == 0){
									echo "<div class='row mb-3'>";
								}
								if($i == 0):
									echo "<div class='col-md-4'><img u-image-id='{$photo->users_gallery_id}' class='img-fluid rounded u_images u_images_1' src='" . URLROOT . "/images/users_images/{$data['user_name']}_images/pbi_images/{$photo->users_gallery_media}' alt=''>";
								else:
									echo "<div class='col-md-4' style='position:relative;'><img u-image-id='{$photo->users_gallery_id}' class='img-fluid rounded u_images' src='" . URLROOT . "/images/users_images/{$data['user_name']}_images/pbi_images/{$photo->users_gallery_media}' alt=''>";
								endif;
								if($data['photos_gallery']->gallery_id === $_SESSION['photos_gallery_id']){
									echo "<form action='" . URLROOT . "/usersgalleries/delete/{$photo->users_gallery_id}'><button class='btn btn-danger delete-u-images delete-u-images-{$photo->users_gallery_id}'><i class='fa fa-trash'></i></button></form>";
								}
								echo "</div>";
								if($i%3 == 2){
									echo "</div>";
								}elseif(($i+1) == $data['users_galleries_media_count_pbi_images']){
									echo "</div>";
								}
								$i++;
							}
						?>
					</div>
				</div>
			</div>
			<div class="posts_gallery_section">
			<h4><?php echo ($data['photos_gallery']->gallery_id !== $_SESSION['photos_gallery_id']) ? $data['user_name'] . "'s" : 'My'; ?> posts images<span style="border-radius: 25px;" class="badge badge-primary pull-right"><?php echo $data['posts_galleries_media_count']; ?></span></h4>
			<img src="" class="big_posts_image mb-3 mt-2" alt="">
			<div class="gray-background"></div>
				<div class="posts-images-section">
					<?php
						$i = 0;
						foreach ($data['posts_galleries_media'] as $photo) {
							if($i%6 == 0){
								echo "<div class='row mb-3'>";
							}
							if($i == 0):
								echo "<div class='col-md-2'><img posts-image-id='{$photo->posts_gallery_id}' class='img-fluid rounded posts_images posts_images_1' src='" . URLROOT . "/images/posts_images/{$data['user_name']}_images/{$photo->posts_gallery_media}' alt=''>";
							else:
								echo "<div class='col-md-2'><img posts-image-id='{$photo->posts_gallery_id}' class='img-fluid rounded posts_images' src='" . URLROOT . "/images/posts_images/{$data['user_name']}_images/{$photo->posts_gallery_media}' alt=''>";
							endif;
							if($data['photos_gallery']->gallery_id === $_SESSION['photos_gallery_id']){
								echo "<form action='" . URLROOT . "/postsgalleries/delete/{$photo->posts_gallery_id}'><button type='submit' 
								class='btn btn-danger delete-posts-images delete-posts-images-{$photo->posts_gallery_id}'><i class='fa fa-trash'></i></button></form>";
							}
							echo "</div>";
							if($i%6 == 5){
								echo "</div>";
							}elseif(($i+1) == $data['posts_galleries_media_count']){
								echo "</div>";
							}
							$i++;
						}
					?>
				</div>
			</div>
		</div>
		<?php if($data['photos_gallery']->gallery_id === $_SESSION['photos_gallery_id']): ?>
		<button data-toggle="modal" data-target="#add_photo" class="btn btn-primary add-photo-button"><i class="fa fa-plus"></i> Add a photo</button>
		<div class="modal fade" id="add_photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add a photo to your gallery</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="<?php echo URLROOT; ?>/personalgalleries/add/<?php echo $data['photos_gallery']->gallery_id; ?>" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-6">
									<input type="file" name="personal_gallery_media" class="form-control">
									</div>
								<div class="col-6">
									<select name="status" class="form-control">
									<option value="published">Publish</option>
									<option value="draft">Draft</option>
									</select>
								</div>
							</div>
							<button type="submit" name="change_personal_gallery_image" class="btn btn-primary pull-right mt-2"><i class="fa fa-plus"></i> add</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>